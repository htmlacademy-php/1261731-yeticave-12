<?php
$title = "Главная";
$is_auth = rand(0, 1);
$user_name = 'Igor'; // укажите здесь ваше имя

function query_result($query) {
    $dbconnection = mysqli_connect("localhost", "Igor", "123", "YetiCave");
    mysqli_set_charset($dbconnection, "utf8");
    if ($dbconnection == false) {
        print("Error connection to data base: " . mysqli_connect_error());
    }

    $query = mysqli_query($dbconnection, $query);

    if (!$query) {
        $error = mysqli_error($dbconnection);
        print("Error in MySQL: " . $error);
    }

    $result = mysqli_fetch_all($query, MYSQLI_ASSOC);

    return $result;
}

$sql_lots = "SELECT Categories.name AS category, Lots.name, cost_start, photo, date_finished AS expiration_time FROM Lots
    INNER JOIN Categories ON Lots.category_id=Categories.id
    LEFT JOIN Rates ON Rates.lot_id=Lots.id
    ORDER BY Lots.id DESC LIMIT 6";
$sql_categories = "SELECT name, symbol_code FROM Categories ORDER BY id ASC";

$lots = query_result($sql_lots);
$categories = query_result($sql_categories);


function cost($cost)
{
    $cost = ceil($cost);
    if (1000 <= $cost) {
        $cost = number_format($cost, 0, '', ' ');
    }

    return $cost . " ";
}

;

function include_template($path, array $data = [])
{
    $path = 'templates/' . $path;
    $page = '';


    if (!is_readable($path)) {
        return $page;
    }

    ob_start();
    extract($data);
    require_once $path;

    $page = ob_get_clean();

    return $page;
}

;

function count_time($expiration_date)
{
    $current_date = date('Y-m-d H:i');

    $diff_in_hour = (strtotime($expiration_date) - strtotime($current_date)) / 3600;
    $diff_in_hour = floor($diff_in_hour);

    $diff_in_min = (strtotime($expiration_date) - strtotime($current_date)) / 60;
    $diff_in_min = $diff_in_min - ($diff_in_hour * 60);
    $diff_in_min = round($diff_in_min);

    if (0 <= $diff_in_hour) {
        $time_limit[] = $diff_in_hour;
        $time_limit[] = $diff_in_min;
    } else {
        $time_limit[] = 0;
        $time_limit[] = 0;
    }

    return $time_limit;
}

$page_content = include_template('main.php', ['lots' => $lots, 'categories' => $categories]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
]);


print($layout_content);
