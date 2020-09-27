<?php
session_start();

require_once('functions/config.php');

$db_connection = connectToDatabase();

$errors = null;
$user_name = $_SESSION['user'] ?? null;
$id = $_GET['id'];
$required_fields = ['cost'];
$categories = getCategories();
$item_lot = getLotQuery($id); 
$cost_current = getCurrentCost($id); 
$time_limited = countTime($item_lot['expiration_time']);
$title = $item_lot['lot_name'];
$menu_lot = includeTemplate('menu_lot.php', ['categories' => $categories]);
$page_content = getPage404($menu_lot, $id, $item_lot);


$rates_history = getHistoryRates($id);

  
$count_rates_history = count($rates_history);

if (isset($_SESSION['user']) && isset($_POST['submit'])) {
        if (isEmpty($required_fields)) {
            $errors = isEmpty($required_fields);
        } else {
                $rules = ['cost' => validateCost($id, 'cost')];

                foreach ($_POST as $key => $value) {
                    if (isset($rules[$key])) {
                        $rule = $rules[$key];
                        $errors[$key] = $rule;
                    }
                }
            }
            
        if (!isset($errors) && isset($_POST['cost'])) {
            inputCost($id, $db_connection);
            header("Location:lot.php?id=$id");

            }

}

if(empty($page_content)) {
    if (isset($_SESSION['user']) && $item_lot['user_id'] !== $_SESSION['user_id'] && $rates_history[0]['user_id'] !== $_SESSION['user_id'] && strtotime(date('Y-m-d H:i')) < strtotime($item_lot['expiration_time'])) {
         
        $lot_form_add_rates_tmp = includeTemplate('lot_form_add_rates_tmp.php', [
            'cost_current' => $cost_current,
            'item_lot' => $item_lot,
            'errors' => $errors
    ]);
       
    } else { 
        $lot_form_add_rates_tmp = '';
    }
    $history_lot = includeTemplate('lot_history_tmp.php', [
        'rates_history' => $rates_history,
        'count_rates_history' => $count_rates_history
    ]); 
    $page_content = includeTemplate('main_lot.php', [
        'menu_lot' => $menu_lot,        
        'time_limited' => $time_limited,
        'lot_form_add_rates_tmp' => $lot_form_add_rates_tmp,
        'item_lot' => $item_lot,
        'history_lot' => $history_lot      
    ]);
}

    $head = includeTemplate('head_lot_index.php', ['title' => $title]);    
    $layout_content = includeTemplate('layout.php', [
        'head' => $head,
        'content' => $page_content,        
        'user_name' => $user_name,        
        'categories' => $categories
    ]);


print($layout_content);

