<?php
$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Process;

$Process = new Process();
$campaign_id = '55312';
$Process->run($campaign_id);

//finish:
//$a = 1;