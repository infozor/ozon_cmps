<?php
$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Process;

$Process = new Process();
$campaign_id = '55312';
$result = $Process->run($campaign_id);
return $result;

//finish:
//$a = 1;