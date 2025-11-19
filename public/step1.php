<?php
//Шаг1 обновить прайс 

$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Main;

//$campaign_id = 55750;
//$campaign_id = 55751;
$campaign_id = 55827;

$file_products = 'D:\site_next\ozon_cmps\data/products_.json';
$json_file_products = file_get_contents($file_products);

$Main = new Main;
$file = $Main->Step1($campaign_id, $json_file_products);
unset($Main);
echo ($file);
