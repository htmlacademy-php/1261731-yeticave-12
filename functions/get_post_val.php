<?php

/**
 * Возвращает значение POST параметра по полученному имени
 * 
 * @param $name имя ключа в POST массиве 
 * 
 * @return mixed|string
 */
function getPostVal($name) {
    return $_POST[$name] ?? "";
}
