<?php
function getPostVal($name) {
    return $_POST[$name] ?? "";
}
