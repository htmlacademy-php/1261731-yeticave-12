<?php
function validate_category($name) {
    if ($_POST[$name] === 'Выберите категорию') {
        return "Не выбрана категория";
    }
}
