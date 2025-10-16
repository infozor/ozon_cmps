<?php
//Шаг6 Получение списка отчётов кампании

$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Main;

$Main = new Main;
//Шаг6 Получение списка отчётов кампании
$file = $Main->Step6();
unset($Main);
echo $file;
