<?php

$title = "Лоты по категориям";

require_once('functions/config.php');
$user_name = $_SESSION['user'] ?? null;

$id_category_lot = $_GET['id_category_lot']; 
$name_category_lot = getCetegoryName($id_category_lot); 
$categories = getCategories();
$menu_lot = includeTemplate('menu_lot.php', ['categories' => $categories]);

$result_search = [];


$amount_item_on_page = $_GET['limit'];
if (isset($_GET['page'])) {
  $number_page = $_GET['page']; 
} else { 
 $number_page = 1;
}

$start_item = ($number_page - 1) * $amount_item_on_page;
$result_search = listLotsByCategories($id_category_lot, $amount_item_on_page, $start_item);
$all_lots_for_id_category = listAllItemsForCategory ($id_category_lot);
$count_all_items_for_pagination = count($all_lots_for_id_category);
$amount_pages = ceil($count_all_items_for_pagination / $amount_item_on_page); 

$pagination_tmp = includeTemplate('pagination_tmp.php', 
                                  [
                                    'id_category_lot' => $id_category_lot,
                                    'amount_pages' => $amount_pages,
                                    'number_page' => $number_page
                                  ]); 
$head = includeTemplate('head_lot_index.php', ['title' => $title]);
$page_content = includeTemplate(
  'lot_by_category_tmp.php',
  [
    'menu_lot' => $menu_lot, 
    'categories' => $categories, 
    'result_search' => $result_search,  
    'name_category_lot' => $name_category_lot,
    'pagination' => $pagination_tmp
  ]
);
$layout_content = includeTemplate('layout.php', [
  'head' => $head,
  'content' => $page_content,
  'title' => $title,
  'user_name' => $user_name,
  'categories' => $categories
]);


print($layout_content);
