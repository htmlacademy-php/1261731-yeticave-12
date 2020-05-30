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
