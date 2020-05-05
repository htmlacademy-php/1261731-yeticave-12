<?php
function getCategories()
{

    $items = queryResult(
        connectToDatabase(),
        "SELECT id, name, symbol_code FROM Categories ORDER BY id ASC");

    return $items;
}

