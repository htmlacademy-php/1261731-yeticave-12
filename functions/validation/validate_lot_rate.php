<?php
function validateLotRate($name) {
    if ($_POST[$name] <= 0) {
        return "Введите число больше ноля";
    }
}
