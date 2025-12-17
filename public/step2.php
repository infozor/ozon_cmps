<?php
//Шаг2 Получение информации о прайсе кампании

$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Main;

$campaign_id = 56373;

$Main = new Main;
$file = $Main->Step2($campaign_id);
unset($Main);
echo ($file);
