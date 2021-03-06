<?php

/**
 * Добавляет в БД новый лот
 * @param $photo путь к фото лота
 * @param $connect подключение к БД
 * 
 * 
 */
function addLot($photo, $connect)
{

    $photo1 = $photo;
    $user_id = $_SESSION['user_id'];
    $category_id = $_POST['category'];
    $name = $_POST['lot-name'];
    $detail = $_POST['message'];
    $cost_start = $_POST['lot-rate'];
    $step_cost = $_POST['lot-step'];
    $date_create = date('Y-m-d');
    $date_finished = $_POST['lot-date'];

    $sql_add_lot = "INSERT INTO Lots (user_id, category_id, name, detail, cost_start, step_cost, photo, date_create, date_finished)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $add_new_lot = mysqli_prepare($connect, $sql_add_lot);
    mysqli_stmt_bind_param($add_new_lot, 'iissiisss', $user_id, $category_id, $name, $detail, $cost_start, $step_cost,
        $photo1, $date_create, $date_finished);
    mysqli_stmt_execute($add_new_lot);
}

/**
 * добавляет новую ставку в БД с привязкой к лоту
 */
function inputCost($id_lot, $connect)
{

    $user_id = $_SESSION['user_id'];
    $lot_id = $id_lot;
    $cost = $_POST['cost'];
    $date_create = date('Y-m-d');

    $sql_add_cost = "INSERT INTO Rates (user_id, lot_id, cost, date_create)
                    VALUES (?, ?, ?, ?)";
    $add_new_cost = mysqli_prepare($connect, $sql_add_cost);
    mysqli_stmt_bind_param($add_new_cost, 'iiis', $user_id, $lot_id, $cost, $date_create);
    mysqli_stmt_execute($add_new_cost);

}

/**
 * Добавляет id победителя в таблицу лотов
 * @param $user_id id победителя
 * @param $lotid id лота
 * 
 */
function inputUseridInLotsTable($userid, $lotid) { 
    $link = connectToDatabase(); 
    $user_id = intval($userid);
    $lot_id = intval($lotid); 
    $sql_update_winnerid = "UPDATE Lots SET winner_id=$user_id WHERE id=$lot_id"; 
    mysqli_query($link, $sql_update_winnerid);

}
