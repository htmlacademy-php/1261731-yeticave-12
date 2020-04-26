<?php
$is_auth = rand(0, 1);
$user_name = 'Igor'; // укажите здесь ваше имя
$required_fields = ['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];


require_once('functions/connect_to_db.php');
require_once('functions/query_result.php');
require_once('functions/cost.php');
require_once('functions/include_template.php');
require_once('functions/count_time.php');
require_once('functions/get_post_val.php');
require_once('functions/load_files.php');
require_once('functions/validation/is_empty.php');
require_once('functions/validation/validate_lot_rate.php');
require_once('functions/validation/validate_lot_step.php');
require_once('functions/validation/validate_category.php');
require_once('functions/validation/compare_dates.php');


$db_connection = connect_to_db();

$sql_categories = "SELECT id, name, symbol_code FROM Categories ORDER BY id ASC";
$categories = query_result($db_connection, $sql_categories);

if (isset($_POST['submit'])) {
    if (isEmpty($required_fields)) {
        $errors = isEmpty($required_fields);
    } else {
        $rules = [
            'lot-rate' => validateLotRate('lot-rate'),
            'lot-step' => validateLotStep('lot-step'),
            'avatar' => loadFiles('avatar'),
            'category' => validate_category('category'),
            'lot-date' => compareDates('lot-date')
        ];

        foreach ($_POST as $key => $value) {
            if (isset($rules[$key])) {
                $rule = $rules[$key];
                $errors[$key] = $rule;
            }
        }
        if (isset($rules['avatar'])) {
            $errors['avatar'] = $rules['avatar'];
        }

    }
    $file_name = $_FILES['avatar']['name'];
}


if (!isset($errors) && isset($_POST['lot-name'])) {

    $user_id = 1;
    $category_id = $_POST['category'];
    $name = $_POST['lot-name'];
    $detail = $_POST['message'];
    $cost_start = $_POST['lot-rate'];
    $step_cost = $_POST['lot-step'];
    $photo = "uploads/" . $file_name;
    $date_create = date('Y-m-d');
    $date_finished = $_POST['lot-date'];

    $sql_add_lot = "INSERT INTO Lots (user_id, category_id, name, detail, cost_start, step_cost, photo, date_create, date_finished)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $add_new_lot = mysqli_prepare($db_connection, $sql_add_lot);
    mysqli_stmt_bind_param($add_new_lot, 'iissiisss', $user_id, $category_id, $name, $detail, $cost_start, $step_cost,
        $photo, $date_create, $date_finished);
    mysqli_stmt_execute($add_new_lot);

    $sql_lot_id = "SELECT id FROM Lots ORDER BY id DESC LIMIT 1";
    $id_last_lot = query_result($db_connection, $sql_lot_id);
    $id_last_lot = $id_last_lot[0]['id'];

    header("Location:lot.php?id=$id_last_lot");
}

$menu_lot = include_template('menu_lot.php', ['categories' => $categories]);
$page_content = include_template('add_lot.php',
    ['menu_lot' => $menu_lot, 'categories' => $categories, 'errors' => $errors]);
$head = include_template('head_add_lot.php');
$layout_content = include_template('layout.php', [
    'head' => $head,
    'content' => $page_content,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
]);


print($layout_content);

