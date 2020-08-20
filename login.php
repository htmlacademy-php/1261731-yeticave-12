<?php
$title = "Вход";
$required_fields = ['email', 'password'];
$errors = [];

require_once('functions/config.php');

$categories = getCategories();

if (isset($_POST['submit'])) {
    if (isEmpty($required_fields)) {
        $errors = isEmpty($required_fields);
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Введите провильный формат email";
        } else {
            $rules = checkUser('email', 'password');

            foreach ($_POST as $key => $value) {
                if (isset($rules[$key])) {
                    $errors[$key] = $rules[$key];
                }

            }

        }
    }
}

if (empty($errors) && isset($_POST['email'])) {
    session_start();

    $user_info = getUserName($_POST['email']);
    $_SESSION['user'] = $user_info[1];
    $_SESSION['user_id'] = $user_info[0];

    header("Location:index.php");
}

$menu_lot = includeTemplate('menu_lot.php', ['categories' => $categories]);
$page_content = includeTemplate(
    'login_tmp.php',
    ['menu_lot' => $menu_lot, 'categories' => $categories, 'errors' => $errors]
);
$head = includeTemplate('head_lot_index.php', ['title' => $title]);
$layout_content = includeTemplate('layout.php', [
    'head' => $head,
    'content' => $page_content,
    'title' => $title,
    'categories' => $categories
]);


print($layout_content);
