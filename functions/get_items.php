<?php

/**
 * @return array|null
 */

function getCategories()
{
    return queryResult(connectToDatabase(), "SELECT id, name, symbol_code FROM Categories ORDER BY id ASC");
}


/**
 * @param $email
 * @return array|null
 */

function getUserName($email)
{
     return queryResult(connectToDatabase(), "SELECT id, name FROM Users WHERE email='$email'");
}

/**
 * @return array|null
 */

function getLots()
{
    $sql_lots = "SELECT Categories.name AS category, Lots.id, Lots.name, cost_start, photo, date_finished AS expiration_time FROM Lots
    INNER JOIN Categories ON Lots.category_id=Categories.id
    LEFT JOIN Rates ON Rates.lot_id=Lots.id
    ORDER BY Lots.id DESC LIMIT 6";

    return queryResult(connectToDatabase(), $sql_lots);
}


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

function getLotQuery($id)
{
    $sql_get_lot = "SELECT Categories.name AS category, Lots.id, Lots.name, cost_start, step_cost, detail, photo, cost, date_finished AS expiration_time FROM Lots 
    INNER JOIN Categories ON Lots.category_id=Categories.id 
    LEFT JOIN Rates ON Rates.lot_id=Lots.id WHERE Lots.id='$id'";

    return $sql_get_lot;
}

function getPage404($menu_lot, $id, $item_lot)
{
    if (empty($id) || empty($item_lot[0])) {
        return includeTemplate('main_404.php', ['menu_lot' => $menu_lot]);
    }
}

function getCurrentCost($id_lot) {
    $sql_get_carrent_cost = "SELECT cost FROM Rates 
                             WHERE lot_id='$id_lot' 
                             ORDER BY cost DESC LIMIT 1";
    $get_cost = queryResult(connectToDatabase(), $sql_get_carrent_cost);
    if (empty($get_cost)) {
        $sql_get_carrent_cost = "SELECT cost_start FROM Lots WHERE id='$id_lot'";

    }

    return queryResult(connectToDatabase(), $sql_get_carrent_cost);
}

function getStepCostLots($id_lot) {
    $sql_get_step_cost = "SELECT step_cost FROM Lots WHERE id='$id_lot'";
    return queryResult(connectToDatabase(), $sql_get_step_cost);
}

function getMyRates($user_id) {
   $sql_get_my_rates = "SELECT Lots.id, Rates.user_id, name, cost, Rates.date_create, photo, winner_id 
                        FROM Lots 
                        RIGHT JOIN Rates ON lot_id=Lots.id 
                        WHERE Rates.user_id='$user_id'";
    return queryResult(connectToDatabase(), $sql_get_my_rates);

}

function getUserContacts($user_id) {
    $sql_get_user_contacts = "SELECT contact FROM Users WHERE id='$user_id'";
    return queryResult(connectToDatabase(), $sql_get_user_contacts);
}

function getIdWinnerLots() {
    $sql_get_id_winner_lot = "SELECT id FROM Lots 
                              WHERE winner_id 
                              IS NULL AND date_finished<=CURRENT_TIMESTAMP";
    $result = queryResult(connectToDatabase(), $sql_get_id_winner_lot);
    return $result;
}

function getLastRateForWinnerLot($id_winner_lot) {
    $sql_get_last_rate_for_winner_lot = "SELECT * FROM Rates 
                                         WHERE lot_id='$id_winner_lot' 
                                         ORDER BY cost DESC LIMIT 1";
    $result = queryResult(connectToDatabase(), $sql_get_last_rate_for_winner_lot);
    return $result [0] ?? null;
}

function getUserInformation($userid) {
    $sql_get_user_information = "SELECT name, email FROM Users WHERE id='$userid'";
    $result = queryResult(connectToDatabase(), $sql_get_user_information);
    return $result [0] ?? null;
}

function getInfoLotForEmail($id)
{
    $sql_get_lot = "SELECT name FROM Lots WHERE id='$id'";
    $result = queryResult(connectToDatabase(), $sql_get_lot);
    return $result [0] ?? null;
}
