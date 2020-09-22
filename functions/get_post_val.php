<?php

/**
 * Возвращает POST значение, которое было введено юзером в форму, если форма не отправилась
 * 
 * @param $name
 * @return mixed|string
 */
function getPostVal($name) {
    return $_POST[$name] ?? "";
}
