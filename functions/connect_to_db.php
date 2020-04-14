<?php
function connect_to_db()
{
    $db_connection = mysqli_connect("localhost", "Igor", "123", "YetiCave");
    mysqli_set_charset($db_connection, "utf8");

    if ($db_connection == false) {
        print("Error connection to data base: " . mysqli_connect_error());
    }

    return $db_connection;
}
