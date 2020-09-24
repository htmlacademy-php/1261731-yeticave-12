<?php

/**
 * Получает из БД информацию о катеогрии лота:
 * id;
 * название категории лота.
 *
 * @return array|null
 */
function getCategories()
{
    return queryResult(connectToDatabase(), "SELECT id, name, symbol_code FROM Categories ORDER BY id ASC");
}


/**
 * Получает из БД информацию о пользователе на основании переданного email
 *
 * Результат: [0=>id пользователя,
 *             1=>имя пользователя
 *            ]
 * @param string $email почта пользователя
 *
 * @return array|null Массив с информацией о пользователе
 */
function getUserName(string $email)
{
    $link = connectToDatabase();
    $user_email = $email;
    $sql_get_name_user = "SELECT id, name FROM Users WHERE email=?";
    $stmt = mysqli_prepare($link, $sql_get_name_user);
    mysqli_stmt_bind_param($stmt, 's',$user_email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_id, $user_name);
    mysqli_stmt_fetch($stmt);
    $result[] = $user_id;
    $result[] = $user_name;
    mysqli_stmt_close($stmt);
    return $result;
}

/**
 * Получение последних шести лотов.
 * По каждому лоту запрос полей:
 * название категории,
 * id лота,
 * название лота,
 * начальная цена,
 * путь к фото лота,
 * дата окончания действия цуны
 *
 * @return array|null
 */
function getLots()
{
    $sql_lots = "SELECT Categories.name AS category, 
                        Lots.id, 
                        Lots.name, 
                        cost_start, 
                        photo, 
                        date_finished AS expiration_time 
                FROM Lots
                INNER JOIN Categories ON Lots.category_id=Categories.id
                WHERE date_finished>current_date
                ORDER BY Lots.id DESC LIMIT 6";
                
    return queryResult(connectToDatabase(), $sql_lots);
}


/**
 * Получение информации о лоте по его id
 *
 * @param int $id
 *
 * @return array|null
 */
function getLotQuery(int $id)
{
    $link = connectToDatabase();
    $lot_id = $id;
    $sql_get_lot = "SELECT Categories.name AS category, 
                           Lots.id, 
                           Lots.name,
                           Lots.user_id, 
                           cost_start, 
                           step_cost, 
                           detail, 
                           photo, 
                           cost, 
                           date_finished AS expiration_time 
                    FROM Lots 
                    INNER JOIN Categories ON Lots.category_id=Categories.id 
                    LEFT JOIN Rates ON Rates.lot_id=Lots.id 
                    WHERE Lots.id=?";
    $stmt = mysqli_prepare($link, $sql_get_lot);
    mysqli_stmt_bind_param($stmt, 's',$lot_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $category, $lot_id, $lot_name, $user_id, $cost_start, $step_cost, $detail, $photo, $cost, $expiration_time);
    mysqli_stmt_fetch($stmt);
    $result["category"] = $category;
    $result["lot_id"] = $lot_id;
    $result["lot_name"] = $lot_name;
    $result["user_id"] = $user_id;
    $result["cost_start"] = $cost_start;
    $result["step_cost"] = $step_cost;
    $result["detail"] = $detail;
    $result["photo"] = $photo;
    $result["cost"] = $cost;
    $result["expiration_time"] = $expiration_time;
    mysqli_stmt_close($stmt);
    return $result;
}

/**
 * Формирование шаблона страницы 404
 *
 * @param mixed|string $menu_lot
 * @param int $id
 * @param string $item_lot
 *
 * @return mixed|string
 */
function getPage404($menu_lot, int $id, $item_lot)
{
    if (empty($id) || empty($item_lot)) {
        return includeTemplate('main_404.php', ['menu_lot' => $menu_lot]);
    }
}

/**
 * Получение последней ставки лота по его id
 * Если ставок нет, то берется стартовая цена лота
 *
 * @param int $id_lot
 *
 * @return array
 */
function getCurrentCost(int $id_lot)
{
    $link = connectToDatabase();
    $sql_get_carrent_cost = "SELECT cost FROM Rates 
                             WHERE lot_id=? 
                             ORDER BY cost DESC LIMIT 1";

    $stmt = mysqli_prepare($link,  $sql_get_carrent_cost);
    mysqli_stmt_bind_param($stmt, 'i',$id_lot);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $get_cost);
    mysqli_stmt_fetch($stmt);
    $result = $get_cost;
    mysqli_stmt_close($stmt);


    if (empty($result)) {
        $sql_get_carrent_cost = "SELECT cost_start FROM Lots WHERE id=?";
        $stmt = mysqli_prepare($link,  $sql_get_carrent_cost);
        mysqli_stmt_bind_param($stmt, 'i',$id_lot);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $get_cost);
        mysqli_stmt_fetch($stmt);
        $result = $get_cost;
        mysqli_stmt_close($stmt);
    }

    return $result;
}

/**
 * Получение минимального размера хода ставки по id лота
 *
 * @param int $id_lot
 *
 * @return array
 */
function getStepCostLots(int $id_lot)
{
    $link = connectToDatabase();
    $sql_get_step_cost = "SELECT step_cost FROM Lots WHERE id=?";
    $stmt = mysqli_prepare($link,   $sql_get_step_cost);
    mysqli_stmt_bind_param($stmt, 'i',$id_lot);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $get_step_cost);
    mysqli_stmt_fetch($stmt);
    $result = $get_step_cost;
    mysqli_stmt_close($stmt);
    return $result;
}

/**
 * Получение информации о ставках пользователя по id пользователя
 *
 * @param int $user_id
 *
 * @return array
 */
function getMyRates(int $user_id)
{
    $link = connectToDatabase();
   $sql_get_my_rates = "SELECT Lots.id, 
                               Rates.user_id,                               
                               name, 
                               cost, 
                               Rates.date_create, 
                               photo, 
                               winner_id 
                        FROM Lots 
                        RIGHT JOIN Rates ON lot_id=Lots.id                          
                        WHERE Rates.user_id=?";
    $stmt = mysqli_prepare($link,   $sql_get_my_rates);
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    
    return $result;

}


/**
 * Получение контактов пользователя по id пользователя
 *
 * @param int $user_id
 *
 * @return array
 */
function getUserContacts(int $user_id)
{
    $link = connectToDatabase();
    $sql_get_user_contacts = "SELECT contact FROM Users WHERE id=?";

    $stmt = mysqli_prepare($link,   $sql_get_user_contacts);
    mysqli_stmt_bind_param($stmt, 'i',$user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $get_user_contacts);
    mysqli_stmt_fetch($stmt);
    $result = $get_user_contacts;
    mysqli_stmt_close($stmt);
    return $result;
}

/**
 * Получение id лота по где есть победивший пользователь и
 * время торгов истекло
 *
 * @return array
 */
function getIdWinnerLots()
{
    $sql_get_id_winner_lot = "SELECT id FROM Lots 
                              WHERE winner_id 
                              IS NULL AND date_finished<=CURRENT_TIMESTAMP";
    $result = queryResult(connectToDatabase(), $sql_get_id_winner_lot);
    return $result;
}

/**
 * Получение последней ставки относщейся к победителю по торгам
 *
 * @param int $id_winner_lot
 *
 * @return array
 */
function getLastRateForWinnerLot(int $id_winner_lot)
{
    $link = connectToDatabase();
    $sql_get_last_rate_for_winner_lot = "SELECT * FROM Rates 
                                         WHERE lot_id=? 
                                         ORDER BY cost DESC LIMIT 1";
    $stmt = mysqli_prepare($link,   $sql_get_last_rate_for_winner_lot);
    mysqli_stmt_bind_param($stmt, 'i',$id_winner_lot);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $lot_id, $user_id, $id, $cost, $date_create);
    mysqli_stmt_fetch($stmt);
    $result["user_id"] = $user_id;
    $result["lot_id"] = $lot_id;
    $result["id"] = $id;
    $result["cost"] = $cost;
    $result["date_creat"] = $date_create;
    mysqli_stmt_close($stmt);

    return $result ?? null;
}

/**
 * Получение имени и почты пользователя по id пользователя
 *
 * @param int $userid
 *
 * @return array
 */
function getUserInformation($userid)
{
    $link = connectToDatabase();
    $sql_get_user_information = "SELECT name, email FROM Users WHERE id=?";

    $stmt = mysqli_prepare($link,   $sql_get_user_information);
    mysqli_stmt_bind_param($stmt, 'i', $userid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $get_user_name, $get_user_email);
    mysqli_stmt_fetch($stmt);
    $result["name"] = $get_user_name;
    $result["email"] = $get_user_email;
    mysqli_stmt_close($stmt);

    return $result ?? null;
}

/**
 * Получение имени лота по его id
 *
 * @param int $id
 *
 * @return array
 */
function getInfoLotForEmail($id)
{
    $link = connectToDatabase();
    $sql_get_lot = "SELECT name FROM Lots WHERE id=?";

    $stmt = mysqli_prepare($link,   $sql_get_lot);
    mysqli_stmt_bind_param($stmt, 'i',$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $get_info_lot_for_email);
    mysqli_stmt_fetch($stmt);
    $result["name"] = $get_info_lot_for_email;
    mysqli_stmt_close($stmt);

    return $result ?? null;
}

/**
 * Получение имени категории по ее id
 *
 * @param int $id_category
 *
 * @return string
 */
function getCetegoryName($id_category)
{
    $link = connectToDatabase();
    $sql_get_category_name = "SELECT name FROM Categories WHERE id=?";
    $stmt = mysqli_prepare($link,   $sql_get_category_name);
    mysqli_stmt_bind_param($stmt, 'i',$id_category);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $get_category_name);
    mysqli_stmt_fetch($stmt);
    $result = $get_category_name;
    mysqli_stmt_close($stmt);

    return $result;

}

/**
 * Получение списка лотов с одинаковой категорией
 *
 * @param int $id_category
 *
 * @return array
 */
function listLotsByCategories(int $id_category, $amount_item_on_page, $start_item)
{
    $link = connectToDatabase();
    $sql_get_list_lots_by_categories = "SELECT
Categories.name, 
Lots.id, 
category_id, 
winner_id, 
user_id, 
Lots.name AS lot_name, 
detail, 
cost_start,
step_cost,
photo,
date_create,
date_finished
FROM Lots INNER JOIN Categories ON Lots.category_id=Categories.id 
WHERE Categories.id=? AND date_finished>current_date LIMIT ? OFFSET ?";

    $stmt = mysqli_prepare($link, $sql_get_list_lots_by_categories);
    mysqli_stmt_bind_param($stmt, 'iii', $id_category, $amount_item_on_page, $start_item);
    mysqli_stmt_execute($stmt);   
    $res = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    
    return $result;
}

/**
 * Поиск лотов по запросу пользователя
 * Реализация поисковой системы по каталогу лотов
 *
 * @return array|null
 */
function searchLots(int $number_page)
{
    $link = connectToDatabase();
    $amount_item_on_page = 9;
    $start_item = ($number_page - 1) * $amount_item_on_page;

    if (isset($_GET['find'])) {
        $query_for_search = trim($_GET['search']);
        if (!empty($query_for_search)) {
            $sql_get_list_lots_by_query_search = 
             "SELECT
             Categories.name, 
             Lots.id, 
             category_id, 
             winner_id, 
             user_id, 
             Lots.name AS lot_name, 
             detail, 
             cost_start,
             step_cost,
             photo,
             date_create,
             date_finished
             FROM Lots INNER JOIN Categories ON Lots.category_id=Categories.id 
             WHERE MATCH(Lots.name, Lots.detail) AGAINST('$query_for_search') 
             LIMIT $amount_item_on_page OFFSET ?";

$stmt = mysqli_prepare($link, $sql_get_list_lots_by_query_search);
mysqli_stmt_bind_param($stmt, 'i', $start_item);
mysqli_stmt_execute($stmt);   
$res = mysqli_stmt_get_result($stmt);
$result = mysqli_fetch_all($res, MYSQLI_ASSOC);

return $result;
        }
    }
}

function allListItemsSearchLots()
{
    $link = connectToDatabase();
    

    if (isset($_GET['find'])) {
        $query_for_search = trim($_GET['search']);
        if (!empty($query_for_search)) {
            $sql_get_list_lots_by_query_search = 
             "SELECT
             Categories.name, 
             Lots.id, 
             category_id, 
             winner_id, 
             user_id, 
             Lots.name AS lot_name, 
             detail, 
             cost_start,
             step_cost,
             photo,
             date_create,
             date_finished
             FROM Lots INNER JOIN Categories ON Lots.category_id=Categories.id 
             WHERE MATCH(Lots.name, Lots.detail) AGAINST(?)";

$stmt = mysqli_prepare($link, $sql_get_list_lots_by_query_search);
mysqli_stmt_bind_param($stmt, 's', $query_for_search);
mysqli_stmt_execute($stmt);   
$res = mysqli_stmt_get_result($stmt);
$result = mysqli_fetch_all($res, MYSQLI_ASSOC);

return $result;
        }
    }
}

/**
 * Возвращает список всей записей из таблицы лотов имеющих категорию, 
 * которую передали в нее
 * 
 * @param int $id_category
 * 
 * @return array
 */
function listAllItemsForCategory (int $id_category) {
    $link = connectToDatabase();
    
        $sql_get_list_lots_by_categories = "SELECT id FROM Lots WHERE category_id=?";    
 
    $stmt = mysqli_prepare($link, $sql_get_list_lots_by_categories);
    mysqli_stmt_bind_param($stmt, 'i', $id_category);
    mysqli_stmt_execute($stmt);   
    $res = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    
    return $result;

}

/**
 * Получение информации о истории ставок лота
 *
 * @param int $lot_id
 *
 * @return array
 */
function getHistoryRates(int $lot_id)
{
    $link = connectToDatabase();
   $sql_get_list_rates = "SELECT name, cost, rates.user_id, rates.date_create 
                        FROM Rates LEFT JOIN Users ON users.id=rates.user_id 
                        WHERE lot_id=? ORDER BY rates.date_create DESC";
    $stmt = mysqli_prepare($link,   $sql_get_list_rates);
    mysqli_stmt_bind_param($stmt, 'i', $lot_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    
    return $result;

}

