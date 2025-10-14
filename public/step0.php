<?php
$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Main;

$Main = new Main;
$file = $Main->Step0();
echo ($file);
