<?php

/**
 * Возвращает список всех катеогрии лотов из таблицы Категорий.
 * Список отсортирован по полю id категории.
 * 
 * Получаемые поля:
 * id категории,
 * название категории лота,
 * символьный код категории.
 *
 * @return array|null
 */
function getCategories()
{
    return queryResult(connectToDatabase(), "SELECT id, name, symbol_code FROM Categories ORDER BY id ASC");
}


/**
 * Возвращает id и имя пользователя на основании переданного email
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
 * Возвращает список последних шести лотов.
 * 
 * Получаемые поля:
 * название категории лота,
 * id лота,
 * название лота,
 * начальная цена лота,
 * путь к фото лота,
 * дата окончания действия торгов по лоту
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
                LEFT JOIN Rates ON Rates.lot_id=Lots.id
                ORDER BY Lots.id DESC LIMIT 6";

    return queryResult(connectToDatabase(), $sql_lots);
}

/**
 * Реализация поисковой системы по каталогу лотов
 * Возвращает список лотов на основании поискового запроса пользователя.
 *
 * Получаемые поля:
 * id лота,
 * id категории,
 * id победителя,
 * id владельца лота,
 * название лота,
 * описание лота,
 * начальная цена лота,
 * шаг ставки,
 * путь к фото лота,
 * дата создания лота,
 * дата завершения торгов по лоту 
 * 
 * @return array|null
 */
function searchLots()
{
    if (isset($_GET['find'])) {
        $query_for_search = trim($_GET['search']);
        if (!empty($query_for_search)) {
            return queryResult(connectToDatabase(),"SELECT
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
WHERE MATCH(Lots.name, Lots.detail) AGAINST('$query_for_search')");
        }
    }
}

/**
 * Возвращает информаци о лоте по его id
 *
 * Получаемые поля:
 * id лота,
 * название категории лота,
 * название лота,
 * описание лота,
 * начальная цена лота,
 * шаг ставки,
 * текущая цена,
 * путь к фото лота,
 * дата завершения торгов по лоту
 * 
 * @param int $id
 *
 * @return array|null
 */
function getLotQuery(int $id)
{
    $link = connectToDatabase();
    $lot_id = $id;
    $sql_get_lot = "SELECT 
                          Categories.name AS category, 
                          Lots.id, 
                          Lots.name, 
                          cost_start, 
                          step_cost, 
                          detail, 
                          photo, 
                          cost, 
                          date_finished AS expiration_time 
                    FROM Lots INNER JOIN Categories ON Lots.category_id=Categories.id 
                    LEFT JOIN Rates ON Rates.lot_id=Lots.id WHERE Lots.id=?";
    $stmt = mysqli_prepare($link, $sql_get_lot);
    mysqli_stmt_bind_param($stmt, 'i', $lot_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $category, $lot_id, $lot_name, $cost_start, $step_cost, $detail, $photo, $cost, $expiration_time);
    mysqli_stmt_fetch($stmt);
    $result["category"] = $category;
    $result["lot_id"] = $lot_id;
    $result["lot_name"] = $lot_name;
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
    $sql_get_carrent_cost = "SELECT cost FROM Rates 
                             WHERE lot_id='$id_lot' 
                             ORDER BY cost DESC LIMIT 1";
    $get_cost = queryResult(connectToDatabase(), $sql_get_carrent_cost);
    if (empty($get_cost)) {
        $sql_get_carrent_cost = "SELECT cost_start FROM Lots WHERE id='$id_lot'";

    }

    return queryResult(connectToDatabase(), $sql_get_carrent_cost);
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
    $sql_get_step_cost = "SELECT step_cost FROM Lots WHERE id='$id_lot'";
    return queryResult(connectToDatabase(), $sql_get_step_cost);
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
   $sql_get_my_rates = "SELECT Lots.id, 
                               Rates.user_id, 
                               name, 
                               cost, 
                               Rates.date_create, 
                               photo, 
                               winner_id 
                        FROM Lots 
                        RIGHT JOIN Rates ON lot_id=Lots.id 
                        WHERE Rates.user_id='$user_id'";
    return queryResult(connectToDatabase(), $sql_get_my_rates);

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
    $sql_get_user_contacts = "SELECT contact FROM Users WHERE id='$user_id'";
    return queryResult(connectToDatabase(), $sql_get_user_contacts);
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
    $sql_get_last_rate_for_winner_lot = "SELECT * FROM Rates 
                                         WHERE lot_id='$id_winner_lot' 
                                         ORDER BY cost DESC LIMIT 1";
    $result = queryResult(connectToDatabase(), $sql_get_last_rate_for_winner_lot);
    return $result [0] ?? null;
}

/**
 * Получение имени и почты пользователя по id пользователя
 *
 * @param int $userid
 *
 * @return array
 */
function getUserInformation(int $userid)
{
    $sql_get_user_information = "SELECT name, email FROM Users WHERE id='$userid'";
    $result = queryResult(connectToDatabase(), $sql_get_user_information);
    return $result [0] ?? null;
}

/**
 * Получение имени лота по его id
 *
 * @param int $id
 *
 * @return array
 */
function getInfoLotForEmail(int $id)
{
    $sql_get_lot = "SELECT name FROM Lots WHERE id='$id'";
    $result = queryResult(connectToDatabase(), $sql_get_lot);
    return $result [0] ?? null;
}

/**
 * Получение имени категории по ее id
 *
 * @param int $id_category
 *
 * @return array
 */
function getCetegoryName(int $id_category)
{
    return queryResult(connectToDatabase(), "SELECT name FROM Categories WHERE id='$id_category'");

}

/**
 * Получение списка лотов с одинаковой категорией
 *
 * @param int $id_category
 *
 * @return array
 */
function listLotsByCategories(int $id_category)
{
            return queryResult(connectToDatabase(),"SELECT
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
WHERE Categories.id='$id_category'");
        }

