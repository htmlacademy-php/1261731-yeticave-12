<?php

$title = "Результаты поиска";

require_once('functions/config.php');
$user_name = $_SESSION['user'] ?? null;


if (isset($_GET['page'])) {
  $number_page = $_GET['page']; 
} else { 
 $number_page = 1;
}

$categories = getCategories();
$menu_lot = includeTemplate('menu_lot.php', ['categories' => $categories]);
$result_search = [];
$pagination_tmp = includeTemplate('pagination_tmp.php');
$count_all_items_for_pagination = count(allListItemsSearchLots()); 
$amount_pages = ceil($count_all_items_for_pagination / 9);

$result_search = searchLots($number_page);

$pagination_tmp = includeTemplate('pagination_search_tmp.php', 
                                  [                                    
                                    'amount_pages' => $amount_pages,
                                    'number_page' => $number_page
                                  ]); 
                                 
$head = includeTemplate('head_lot_index.php', ['title' => $title]);
$page_content = includeTemplate(
    'search_tmp.php',
    [
        'menu_lot' => $menu_lot, 
        'categories' => $categories, 
        'result_search' => $result_search,
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

