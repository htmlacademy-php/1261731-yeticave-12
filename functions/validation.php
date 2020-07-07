<?php
require_once('constants.php');

/**
 * @param string $date
 * @return string
 */

function compareDates(string $date)
{
    $current_date = date(DATE);
    $format_to_check = DATE;

    $dateTimeObj = date_create_from_format($format_to_check, $_POST[$date]);


    if ($_POST[$date] <= $current_date || $dateTimeObj == false) {
        return "Введите дату больше текущей даты в формате ГГГГ-ММ-ДД";
    }
}


/**
 * @param $required_fields
 * @return array
 */

function isEmpty($required_fields)
{
    $errors = [];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }
    return $errors = array_filter($errors);
}


/**
 * @param $name
 * @return string
 */

function validateCategory($name)
{
    if ($_POST[$name] === 'Выберите категорию') {
        return "Не выбрана категория";
    }
}

/**
 * @param $name
 * @return string
 */

function validateFiles($name)
{
    if (!empty($_FILES[$name]['name'])) {
        $file_tmp = $_FILES[$name]['tmp_name'];
        $file_type = mime_content_type($file_tmp);
        $png = "image/png";
        $jpeg = "image/jpeg";


        if (strcmp($file_type, $png) == 1 || strcmp($file_type, $jpeg) == 1) {

            return "Загрузите картинку (графический файл) в формате: jpg, jpeg, png";
        }

    }
}

/**
 * @param $name
 * @return string
 */

function validateLotRate($name)
{
    if ($_POST[$name] <= 0) {
        return "Введите число больше ноля";
    }
}

/**
 * @param $name
 * @return string
 */

function validateLotStep($name)
{
    $name = $_POST[$name];
    $point = '.';
    if (!is_numeric($name) || strpos($name, $point) || $name <= 0) {
        return "Введите цело положительное чило";
    }
}

/**
 * @param $name
 * @return string
 */

function validateFormatEmail($name)
{
    $name = $_POST[$name];
    $items = queryResult(
        connectToDatabase(),
        "SELECT email FROM Users WHERE email LIKE '" . $name . "'");

    if (!empty($items)) {
        return "Email уже занят";
    }

}

/**
 * @param $email
 * @param $password
 * @return array
 */

function checkUser($email, $password)
{
    $errors = [];
    $email = $_POST[$email];


    $sql_hash = "SELECT password FROM Users WHERE email='$email'";
    $hash_from_db = queryResult(connectToDatabase(), $sql_hash);
    $hash_from_db = $hash_from_db[0][$password];

    if (empty($hash_from_db)) {
        $errors['email'] = "Email не верен";
    }

    if (!password_verify($_POST[$password], $hash_from_db)) {
        $errors['password'] = "Не корректный пароль";
    }

    return $errors;
}

function validateCost()
{

}

function checkCostLot($required_fields)
{
    if (isset($_POST['submit'])) {
        if (isEmpty($required_fields)) {
            $errors = isEmpty($required_fields);
        } else {
            $rules = [
                'cost' => validateCost('cost')
            ];

            foreach ($_POST as $key => $value) {
                if (isset($rules[$key])) {
                    $rule = $rules[$key];
                    $errors[$key] = $rule;
                }
                if (isset($rules['avatar'])) {
                    $errors['avatar'] = $rules['avatar'];
                }
            }
        }
    }
}

