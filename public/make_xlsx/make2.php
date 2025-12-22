<?php
$path = realpath(__DIR__ . '/../../vendor/');
require $path . '/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$data = [
		['ID', 'Марка', 'Модель', 'Год'],
		[1, 'Toyota', 'Camry', 2018],
		[2, 'BMW', 'X5', 2020],
		[3, 'Lada', 'Vesta', 2022],
];

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->fromArray($data, null, 'A1');   // <<< вот это главное

$directory = realpath(__DIR__ . '/../../config/pdata/');
$outputFile = $directory . '/make_result.xlsx';

$writer = new Xlsx($spreadsheet);
$writer->save($outputFile);

echo "Файл сохранён: $outputFile";

