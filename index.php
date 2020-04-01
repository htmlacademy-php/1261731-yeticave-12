<?php
$title = "Главная";
$is_auth = rand(0, 1);

$user_name = 'Igor'; // укажите здесь ваше имя

$categories = [
    "Доски и лыжи",
    "Крепления",
    "Ботинки",
    "Одежда",
    "Инструменты",
    "Разное"
];

$lots = [
    [
        "name" => "2014 Rossignol District Snowboard",
        "category" => $categories[0],
        "cost" => 10999,
        "url" => "img/lot-1.jpg",
        "expiration_time" => "2020-04-01"
    ],
    [
        "name" => "DC Ply Mens 2016/2017 Snowboard",
        "category" => $categories[0],
        "cost" => 159999,
        "url" => "img/lot-2.jpg",
        "expiration_time" => "2020-10-20"
    ],
    [
        "name" => "Крепления Union Contact Pro 2015 года размер L/XL",
        "category" => $categories[1],
        "cost" => 8000,
        "url" => "img/lot-3.jpg",
        "expiration_time" => "2020-04-30"
    ],
    [
        "name" => "Ботинки для сноуборда DC Mutiny Charocal",
        "category" => $categories[2],
        "cost" => 10999,
        "url" => "img/lot-4.jpg",
        "expiration_time" => "2020-08-20"
    ],
    [
        "name" => "Куртка для сноуборда DC Mutiny Charocal",
        "category" => $categories[3],
        "cost" => 7500,
        "url" => "img/lot-5.jpg",
        "expiration_time" => "2020-09-21"
    ],
    [
        "name" => "Маска Oakley Canopy",
        "category" => $categories[5],
        "cost" => 5400,
        "url" => "img/lot-6.jpg",
        "expiration_time" => "2020-07-20"
    ]

];


function cost($cost)
{
    $cost = ceil($cost);
    if (1000 <= $cost) {
        $cost = number_format($cost, 0, '', ' ');
    }

    return $cost . " ";
}

;

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

;

function count_time($expiration_date)
{
    $current_date = date('Y-m-d H:i');

    $diff_in_hour = (strtotime($expiration_date) - strtotime($current_date)) / 3600;
    $diff_in_hour = floor($diff_in_hour);

    $diff_in_min = (strtotime($expiration_date) - strtotime($current_date)) / 60;
    $diff_in_min = $diff_in_min - ($diff_in_hour * 60);
    $diff_in_min = round($diff_in_min);

    if (0 <= $diff_in_hour) {
        $time_limit[] = $diff_in_hour;
        $time_limit[] = $diff_in_min;
    } else {
        $time_limit[] = 0;
        $time_limit[] = 0;
    }

    return $time_limit;
}

$page_content = include_template('main.php', ['lots' => $lots, 'categories' => $categories]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories
]);


print($layout_content);
