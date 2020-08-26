<?php


/**
 * Возвращает массив с данными из БД по сформированной команде sql
 * 
 * @param $db_connection ресурс подключения к БД
 * @param $query SQL запрс
 * @return array|null
 */
function queryResult($db_connection, $query) {

    $query = mysqli_query($db_connection, $query);

    if (!$query) {
        $error = mysqli_error($db_connection);
        print("Error in MySQL: " . $error);
    }

    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

    return $result;
}
