<?php
//Шаг1 обновить прайс 

$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Main;

$Main = new Main;
$file = $Main->Step1();
unset($Main);
echo ($file);
