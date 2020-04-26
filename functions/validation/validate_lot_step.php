<?php
function validateLotStep($name) {
    $name = $_POST[$name];
    $point = '.';
    if (!is_numeric($name) || strpos($name, $point) || $name <= 0) {
        return "Введите цело положительное чило";
    }
}

