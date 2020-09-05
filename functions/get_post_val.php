<?php

/**
 * @param $name
 * @return mixed|string
 */
function getPostVal($name) {
    return $_POST[$name] ?? "";
}
