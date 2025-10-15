<?php
//Шаг5 Получение результатов парсинга отчёта

$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Main;

$Main = new Main;
$file = $Main->Step6();
unset($Main);
echo $file;
