<?php

/**
 * @return false|mysqli
 */

function connectToDatabase()
{
    $db_connection = mysqli_connect("localhost", "Igor", "123", "YetiCave");
    mysqli_set_charset($db_connection, "utf8");

    if ($db_connection == false) {
        die("Error connection to data base: " . mysqli_connect_error());
    }

    return $db_connection;
}
