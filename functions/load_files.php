<?php
function loadFiles($name)
{
    if (!empty($_FILES[$name]['name'])) {
        $file_tmp = $_FILES[$name]['tmp_name'];

        $file_type = mime_content_type($file_tmp);
        $png = "image/png";
        $jpeg = "image/jpeg";

        if (strcasecmp($file_type, $png) == 0 || strcasecmp($file_type, $jpeg) == 0) {

            $main_path = '/var/www/html/academyphp1/1261731-yeticave-12';
            $file_path = $main_path . '/uploads/';
            $file_name = $_FILES[$name]['name'];
            var_dump(move_uploaded_file($_FILES[$name]['tmp_name'], $file_path . $file_name));

        } else {
            return "Загрузите файл формата: jpg, jpeg, png";
        }

    }

}
