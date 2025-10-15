<?php
//Шаг4 Получение информации об отчёте

$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Main;

$Main = new Main;
$file = $Main->Step4();
unset($Main);
echo ($file);
