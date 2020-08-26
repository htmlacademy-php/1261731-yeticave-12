<?php

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * 
 * @param $path Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return false|string Итоговый HTML
 */
function includeTemplate($path, array $data = [])
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
