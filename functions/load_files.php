<?php

/**
 * @param $name
 */

function loadFiles($name)
{

    $main_path = __DIR__ . '/../';
    $file_path = $main_path . 'uploads/';
    $file_name = $_FILES[$name]['name'];
    move_uploaded_file($_FILES[$name]['tmp_name'], $file_path . $file_name);


}
