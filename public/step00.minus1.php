<?php
$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Main;

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

$file = 'monitoring_avto.xlsx';

$directory = realpath(__DIR__ . '/../config/pdata/');

$inputFileName = $directory . '/' . $file;

$reader = new Xlsx();
$spreadsheet = $reader->load($inputFileName);

// Получаем лист по имени

$list = 'Лист1';
//$list = 'Лист2';

$worksheet = $spreadsheet->getSheetByName($list);

// Если лист существует, получаем данные
if ($worksheet !== null)
{
	$sheetData = $worksheet->toArray(null, true, true, true);
	//print_r($sheetData);
}
else
{
	echo "Лист '".$list."' не найден";
}

//$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);



$Main = new Main();
$file = $Main->Step00minus1($sheetData);
unset($Main);
echo ($file);
