<?php
$title = "Регистрация";
$required_fields = ['email', 'password', 'name', 'message'];

require_once('functions/connect_to_db.php');
require_once('functions/query_result.php');
require_once('functions/get_post_val.php');
require_once('functions/include_template.php');
require_once('functions/validation.php');
require_once('functions/constants.php');

$db_connection = connectToDatabase();

$sql_categories = "SELECT id, name, symbol_code FROM Categories ORDER BY id ASC";
$categories = queryResult($db_connection, $sql_categories);

if (isset($_POST['submit'])) {
    if (isEmpty($required_fields)) {
        $errors = isEmpty($required_fields);
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Введите провильный формат email";
        } else {
            $sql_email = "SELECT email FROM Users";
            $emails = queryResult($db_connection, $sql_email);
            $rules = [
                'email' => validateFormatEmail('email', $emails)
            ];

            foreach ($_POST as $key => $value) {
                if (isset($rules[$key])) {
                    $rule = $rules[$key];
                    $errors[$key] = $rule;
                }

            }

        }
    }
}


if (!isset($errors) && isset($_POST['email'])) {

    $name_user = $_POST['name'];
    $email_user = $_POST['email'];
    $password_user = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $contacts_user = $_POST['message'];
    $date_create = date(DATE);

    $sql_add_lot = "INSERT INTO Users (name, email, password, contact, date_registration) VALUES (?, ?, ?, ?, ?)";
    $add_new_lot = mysqli_prepare($db_connection, $sql_add_lot);
    mysqli_stmt_bind_param($add_new_lot, 'sssss', $name_user, $email_user, $password_user, $contacts_user, $date_create);
    mysqli_stmt_execute($add_new_lot);

    header("Location:index.php");
}


$menu_lot = includeTemplate('menu_lot.php', ['categories' => $categories]);
$page_content = includeTemplate('sign_up.php',
    ['menu_lot' => $menu_lot, 'categories' => $categories, 'errors' => $errors]);
$head = includeTemplate('head_lot_index.php', ['title' => $title]);
$layout_content = includeTemplate('layout.php', [
    'head' => $head,
    'content' => $page_content,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
]);


print($layout_content);
