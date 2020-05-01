<?php
require_once('constants.php');

function compareDates(string $date) {
    $current_date = date(DATE);
    $format_to_check = DATE;

    $dateTimeObj = date_create_from_format($format_to_check, $_POST[$date]);


    if ($_POST[$date] <= $current_date || $dateTimeObj == false) {
        return "Введите дату больше текущей даты в формате ГГГГ-ММ-ДД";
    }
}

function isEmpty($required_fields) {
    $errors = [];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }
    return $errors = array_filter($errors);
}

function validateCategory($name) {
    if ($_POST[$name] === 'Выберите категорию') {
        return "Не выбрана категория";
    }
}

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

function validateLotRate($name) {
    if ($_POST[$name] <= 0) {
        return "Введите число больше ноля";
    }
}

function validateLotStep($name) {
    $name = $_POST[$name];
    $point = '.';
    if (!is_numeric($name) || strpos($name, $point) || $name <= 0) {
        return "Введите цело положительное чило";
    }
}

