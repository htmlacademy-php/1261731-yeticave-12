<?php
function include_template($path, array $data = [])
{
    $path = 'templates/' . $path;
    $page = '';


    if (!is_readable($path)) {
        return $page;
    }

    ob_start();
    extract($data);
    require_once $path;

    $page = ob_get_clean();

    return $page;
}
