<?php
//Шаг7 Обновление таблицы с товарами - установка найденных цен

$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Main;

$Main = new Main;
//Шаг7 Обновление таблицы с товарами - установка найденных цен
$file = $Main->Step7();
unset($Main);
echo $file;
