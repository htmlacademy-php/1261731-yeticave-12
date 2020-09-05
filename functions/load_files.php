<?php

/**
 * Загрузка файла с картинкой на сервер
 * 
 * @param $name
 */
function loadFiles(string $name)
{

    $main_path = __DIR__ . '/../';
    $file_path = $main_path . 'uploads/';
    $file_name = $_FILES[$name]['name'];
    move_uploaded_file($_FILES[$name]['tmp_name'], $file_path . $file_name);


}
