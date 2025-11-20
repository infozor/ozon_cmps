<?php
$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Main;

//подготовка json файла с товарами
$Main = new Main;
$file = $Main->Step00();
unset($Main);
echo ($file);
