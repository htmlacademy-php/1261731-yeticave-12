<?php
$title = "Главная";
$is_auth = rand(0, 1);
$user_name = 'Igor'; // укажите здесь ваше имя

require_once('functions/connect_to_db.php');
require_once('functions/query_result.php');
require_once('functions/cost.php');
require_once('functions/include_template.php');
require_once('functions/count_time.php');


$db_connection = connect_to_db();

$sql_lots = "SELECT Categories.name AS category, Lots.id, Lots.name, cost_start, photo, date_finished AS expiration_time FROM Lots
    INNER JOIN Categories ON Lots.category_id=Categories.id
    LEFT JOIN Rates ON Rates.lot_id=Lots.id
    ORDER BY Lots.id DESC LIMIT 6";
$lots = query_result($db_connection, $sql_lots);

$sql_categories = "SELECT name, symbol_code FROM Categories ORDER BY id ASC";
$categories = query_result($db_connection, $sql_categories);


$menu_category = include_template('menu_index.php', ['categories' => $categories]);
$page_content = include_template('main.php', ['lots' => $lots, 'menu_category' => $menu_category]);
$head = include_template('head_lot_index.php');
$layout_content = include_template('layout.php', [
    'head' => $head,
    'content' => $page_content,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
]);


print($layout_content);
