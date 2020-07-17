<?php
session_start();

require_once('functions/config.php');

//коннект к БД
$db_connection = connectToDatabase();

//подготовка переменных для шаблона
$title = "Мои ставки";
$user_name = $_SESSION['user'];
$user_id = $_SESSION['user_id'];
$categories = getCategories();
$my_rates = getMyRates($user_id); die("my_rates 13"); //разработка метод получения массива ставок

//сборка шаблона
$menu_lot = includeTemplate('menu_lot.php', ['categories' => $categories]); 
$page_content = includeTemplate('myrates_tmp.php',
    ['menu_lot' => $menu_lot, 'categories' => $categories, 'errors' => $errors]);
$head = includeTemplate('head_add_lot.php');
$layout_content = includeTemplate('layout.php', [
    'head' => $head,
    'content' => $page_content,
    'title' => $title,    
    'user_name' => $user_name,
    'categories' => $categories
]);


print($layout_content);
