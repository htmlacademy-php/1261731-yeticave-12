<?php
session_start();

$title = "Главная";

$user_name = $_SESSION['user']; // укажите здесь ваше имя

require_once('functions/config.php');

$lots = getLots();

$categories = getCategories();

$menu_category = includeTemplate('menu_index.php', ['categories' => $categories]);
$page_content = includeTemplate('main.php', ['lots' => $lots, 'menu_category' => $menu_category]);
$head = includeTemplate('head_lot_index.php');
$layout_content = includeTemplate('layout.php', [
    'head' => $head,
    'content' => $page_content,
    'title' => $title,
    'user_name' => $user_name,
    'categories' => $categories
]);


print($layout_content);

