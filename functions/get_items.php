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


function searchLots($query_from_user)
{
    return  queryResult(connectToDatabase(),"SELECT * FROM Lots INNER JOIN Categories ON Lots.category_id=Categories.id WHERE MATCH(Lots.name, Lots.detail) AGAINST('$query_from_user')");
}
