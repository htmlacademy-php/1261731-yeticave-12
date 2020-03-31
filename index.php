<?php
$title = "Главная";
$is_auth = rand(0, 1);

$user_name = 'Igor'; // укажите здесь ваше имя
$i = 0;
$j = 0;
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
        "url" => "img/lot-1.jpg"
    ],
    [
        "name" => "DC Ply Mens 2016/2017 Snowboard",
        "category" => $categories[0],
        "cost" => 	159999,
        "url" => "img/lot-2.jpg"
    ],
    [
        "name" => "Крепления Union Contact Pro 2015 года размер L/XL",
        "category" => $categories[1],
        "cost" => 	8000,
        "url" => "img/lot-3.jpg"
    ],
    [
        "name" => "Ботинки для сноуборда DC Mutiny Charocal",
        "category" => $categories[2],
        "cost" => 	10999,
        "url" => "img/lot-4.jpg"
    ],
    [
        "name" => "Куртка для сноуборда DC Mutiny Charocal",
        "category" => $categories[3],
        "cost" => 	7500,
        "url" => "img/lot-5.jpg"
    ],
    [
        "name" => "Маска Oakley Canopy",
        "category" => $categories[5],
        "cost" => 	5400,
        "url" => "img/lot-6.jpg"
    ]

];
$sizeArray = count($categories);

function cost($cost) {
    $cost = ceil($cost);
    if (1000 <= $cost) {
        $cost = number_format($cost, 0, '', ' ');
    }

    return $cost." ";
};

function include_template($path, $data = []) {

    foreach ($data as $key => $value) {
       $$key = $value;
    };

    $page = require_once($path);

    return $page;
};

$page_content = include_template('templates/main.php', ['lots' => $lots, 'categories' => $categories]);
$layout_content = include_template('templates/layout.php', ['content' => $page_content, 'title' => $title, 'user_name' => $user_name]);


print($layout_content);
