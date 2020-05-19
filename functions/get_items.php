<?php

/**
 * @return array|null
 */

function getCategories()
{

    $items = queryResult(
        connectToDatabase(),
        "SELECT id, name, symbol_code FROM Categories ORDER BY id ASC");

    return $items;
}


/**
 * @param $email
 * @return array|null
 */

function getUserName($email) {
    $get_user_name = queryResult(
        connectToDatabase(),
        "SELECT id, name FROM Users WHERE email='$email'");

    return $get_user_name;
}
