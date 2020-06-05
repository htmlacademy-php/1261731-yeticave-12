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

function getLot($id)
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

function getCostFromRates($id)
{
    $sql_cost = "SELECT l.id, name, cost_start, step_cost, cost FROM Lots l 
                 LEFT JOIN Rates ON lot_id=l.id 
                 WHERE l.id='$id' 
                 ORDER BY cost DESC LIMIT 1";

    return queryResult(connectToDatabase(), $sql_cost);
}
