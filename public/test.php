<?php
$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Main;

$Main = new Main;
$result = $Main->Test();
echo ($result);
