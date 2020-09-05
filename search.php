<?php

$title = "Результаты поиска";

require_once('functions/config.php');
$user_name = $_SESSION['user'] ?? null;

$categories = getCategories();
$menu_lot = includeTemplate('menu_lot.php', ['categories' => $categories]);
$result_search = [];

$result_search = searchLots();


$head = includeTemplate('head_lot_index.php', ['title' => $title]);
$page_content = includeTemplate(
    'search_tmp.php',
    ['menu_lot' => $menu_lot, 'categories' => $categories, 'result_search' => $result_search]
);
$layout_content = includeTemplate('layout.php', [
    'head' => $head,
    'content' => $page_content,
    'title' => $title,
    'user_name' => $user_name,
    'categories' => $categories
]);


print($layout_content);

