<?php
session_start();

require_once('functions/config.php');

$user_name = $_SESSION['user']; // укажите здесь ваше имя
$id = $_GET['id'];
$required_fields = ['cost'];

$db_connection = connectToDatabase();

$categories = getCategories();
$item_lot = queryResult($db_connection, getLot($id));
$time_limited = countTime($item_lot[0]['expiration_time']);
$title = $item_lot[0]['name'];

$menu_lot = includeTemplate('menu_lot.php', ['categories' => $categories]);

$page_content = getPage404($menu_lot, $id, $item_lot);




if(empty($page_content)) {
    $page_content = includeTemplate('main_lot.php', [
        'menu_lot' => $menu_lot,
        'item_lot' => $item_lot,
        'time_limited' => $time_limited
    ]);
}

    $head = includeTemplate('head_lot_index.php');
    $layout_content = includeTemplate('layout.php', [
        'head' => $head,
        'content' => $page_content,
        'title' => $title,
        'user_name' => $user_name,
        'categories' => $categories
    ]);


print($layout_content);

