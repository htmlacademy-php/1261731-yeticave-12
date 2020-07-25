<?php
session_start();

require_once('functions/config.php');

//коннект к БД
$db_connection = connectToDatabase();

//подготовка переменных для шаблона
$user_name = $_SESSION['user'];
$id = $_GET['id'];
$required_fields = ['cost'];
$categories = getCategories();
$item_lot = queryResult($db_connection, getLot($id));
$time_limited = countTime($item_lot[0]['expiration_time']);
$title = $item_lot[0]['name'];
$menu_lot = includeTemplate('menu_lot.php', ['categories' => $categories]);
$page_content = getPage404($menu_lot, $id, $item_lot);

//проверка формы
if (isset($_SESSION['user'])) {
    if (isset($_POST['submit'])) {
        if (isEmpty($required_fields)) {
            $errors = isEmpty($required_fields); // если поле не заполнено присваивает массив [название поля => суть ошибки]
        } else {
                $rules = ['cost' => validateCost($id, 'cost')]; //массив [название поля => суть ошибки]

                foreach ($_POST as $key => $value) {
                    if (isset($rules[$key])) {
                        $rule = $rules[$key];
                        $errors[$key] = $rule; //пишем массив с ошибками
                    }
                }
            }

        if (!isset($errors) && isset($_POST['cost'])) {
            inputCost($id, $db_connection); //добавляем ставку

            }
    }
}

//если не 404, то формируем контент страницы
if(empty($page_content)) {
    $page_content = includeTemplate('main_lot.php', [
        'menu_lot' => $menu_lot,
        'item_lot' => $item_lot,
        'time_limited' => $time_limited,
        'errors' => $errors
    ]);
}

//сборка шаблона
    $head = includeTemplate('head_lot_index.php');
    $layout_content = includeTemplate('layout.php', [
        'head' => $head,
        'content' => $page_content,
        'title' => $title,
        'user_name' => $user_name,
        'categories' => $categories
    ]);


print($layout_content);

