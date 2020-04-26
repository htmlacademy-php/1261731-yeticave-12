<?php
function isEmpty($required_fields) {
    $errors = [];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }
    return $errors = array_filter($errors);
}
