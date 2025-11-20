<?php
$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Main;


$sku = '2685461578';
		
$Main = new Main();
$result = $Main->Step00minus2($sku);
unset($Main);

print_r($result);

