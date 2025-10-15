<?php
// Шаг3 Создание отчёта по кампании

$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Main;

$Main = new Main;
$file = $Main->Step3();
unset($Main);
echo ($file);
