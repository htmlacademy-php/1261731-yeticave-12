<?php
/**
 * возвращает значение переданное в POST
 * @param $name
 * 
 */
function getPostVal($name) {
    return $_POST[$name] ?? "";
}

    
