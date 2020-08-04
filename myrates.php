<?php
session_start();

require_once('functions/config.php');

$db_connection = connectToDatabase();

$title = "Мои ставки";
$user_name = $_SESSION['user'];
$user_id = $_SESSION['user_id'];
$categories = getCategories();
$user_contacts = getUserContacts($user_id); 
$my_rates = getMyRates($user_id); 

$menu_lot = includeTemplate('menu_lot.php', ['categories' => $categories]); 
$page_content = includeTemplate('myrates_tmp.php', [
    'menu_lot' => $menu_lot, 
    'categories' => $categories,
    'user_contacts' => $user_contacts, 
    'my_rates' => $my_rates,
    'errors' => $errors
   ]);
$head = includeTemplate('head_add_lot.php');
$layout_content = includeTemplate('layout.php', [
    'head' => $head,
    'content' => $page_content,
    'title' => $title,    
    'user_name' => $user_name,
    'categories' => $categories
   ]);


print($layout_content);
