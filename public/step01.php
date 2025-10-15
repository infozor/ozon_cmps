<?php
$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Main;

$Main = new Main;
//Список кампаний
$result = $Main->Step01();
unset($Main);

echo ($result);
