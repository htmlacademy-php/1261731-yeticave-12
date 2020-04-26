<?php
function compareDates(string $date) {
    $current_date = date('Y-m-d');
    $format_to_check = 'Y-m-d';

    $dateTimeObj = date_create_from_format($format_to_check, $_POST[$date]);


    if ($_POST[$date] <= $current_date || $dateTimeObj == false) {
        return "Введите дату больше текущей даты в формате ГГГГ-ММ-ДД";
    }
}
