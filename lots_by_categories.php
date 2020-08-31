<?php

$title = "Лоты по категориям";

require_once('functions/config.php');
$user_name = $_SESSION['user'] ?? null;

$id_category_lot = $_GET['id_category_lot']; 
$name_category_lot = getCetegoryName($id_category_lot); 
$categories = getCategories();
$menu_lot = includeTemplate('menu_lot.php', ['categories' => $categories]);
$result_search = [];


$result_search = listLotsByCategories($id_category_lot); 

$head = includeTemplate('head_lot_index.php', ['title' => $title]);
$page_content = includeTemplate(
  'lot_by_category_tmp.php',
  ['menu_lot' => $menu_lot, 'categories' => $categories, 'result_search' => $result_search,  'name_category_lot' => $name_category_lot]
);
$layout_content = includeTemplate('layout.php', [
  'head' => $head,
  'content' => $page_content,
  'title' => $title,
  'user_name' => $user_name,
  'categories' => $categories
]);


print($layout_content);
