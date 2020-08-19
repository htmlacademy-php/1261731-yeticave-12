<?php
session_start();

if (isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}

$title = "Регистрация";
$required_fields = ['email', 'password', 'name', 'message'];
$errors =[];

require_once('functions/config.php');

$categories = getCategories();

if (isset($_POST['submit'])) {
    if (isEmpty($required_fields)) {
        $errors = isEmpty($required_fields);
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Введите провильный формат email";
        } else {
            $rules = [
                'email' => validateFormatEmail('email')
            ];

            foreach ($_POST as $key => $value) {
                if (isset($rules[$key])) {
                    $errors[$key] = $rules[$key];
                }

            }

        }
    }
}


if (!isset($errors) && isset($_POST['email'])) {
$db = connectToDatabase();
    $name_user = $_POST['name'];
    $email_user = $_POST['email'];
    $password_user = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $contacts_user = $_POST['message'];
    $date_create = date(DATE);

    $sql_add_lot = "INSERT INTO Users (name, email, password, contact, date_registration) VALUES (?, ?, ?, ?, ?)";
    $add_new_lot = mysqli_prepare($db, $sql_add_lot);
    mysqli_stmt_bind_param($add_new_lot, 'sssss', $name_user, $email_user, $password_user, $contacts_user, $date_create);
    mysqli_stmt_execute($add_new_lot);

    header("Location:index.php");
}


$menu_lot = includeTemplate('menu_lot.php', ['categories' => $categories]);
$page_content = includeTemplate(
    'sign_up.php',
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
