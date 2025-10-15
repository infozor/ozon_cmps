<?php
$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Main;

$Main = new Main();

/*
 *
 * "ListCampaigns": {
 * "type": "GET",
 * "method_part0": "campaigns.json"
 * },
 * "UpdatePrice": {
 * "type": "POST",
 * "method_part0": "campaigns/",
 * "method_var0": "CAMPAIGN_ID",
 * "method_part1": "/price.json"
 * },
 * "GetPriceStatus": {
 * "type": "GET",
 * "method_part0": "campaigns/",
 * "method_var0": "CAMPAIGN_ID",
 * "method_part1": "/price.json"
 * },
 * "CreateReport": {
 * "type": "POST",
 * "method_part0": "campaigns/",
 * "method_var0": "CAMPAIGN_ID",
 * "method_part1": "/reports.json"
 * },
 * "GetReportStatus": {
 * "type": "POST",
 * "method_part0": "campaigns/",
 * "method_var0": "CAMPAIGN_ID",
 * "method_part1": "/reports/",
 * "method_var1": "REPORT_ID",
 * "method_part2": ".json"
 * },
 * "GetReportResults": {
 * "type": "GET",
 * "method_part0": "campaigns/",
 * "method_var0": "CAMPAIGN_ID",
 * "method_part1": "/reports/",
 * "method_var1": "REPORT_ID",
 * "method_part2": "/results.json"
 * },
 * "GetCampaignsReports": {
 * "type": "GET",
 * "method_part0": "campaigns/",
 * "method_var0": "CAMPAIGN_ID",
 * "method_part1": "/reports.json"
 * }
 *
 */

$campaign_id = '55310';

goto start4;

// -----------------------------------------------------------------------------
// подготовка json файла с товарами
// -----------------------------------------------------------------------------
$file_products = $Main->Step00();
// $file_products = 'D:\site_next\ozonparsemark\data/products_151025_140228.json';
$json_file_products = file_get_contents($file_products);

// $json_file_products = $file_products;

$array_file_products = json_decode($json_file_products, true);

// -----------------------------------------------------------------------------
// получить список кампаний ListCampaigns
// -----------------------------------------------------------------------------
$json_list_campaigns = $Main->Step01();

$array_list_campaigns = json_decode($json_list_campaigns, true);

$date = date('dmy_His');
$file_data = realpath(__DIR__ . '/../data/') . '/' . 'campaigns_' . $date . '.json';
file_put_contents($file_data, $json_list_campaigns, FILE_APPEND);

// -----------------------------------------------------------------------------
// обновить перезалить прайс лист с товарами UpdatePrice
// -----------------------------------------------------------------------------

$file = $Main->Step1($campaign_id, $json_file_products);

start2:
// -----------------------------------------------------------------------------
// Шаг2 Получение информации о прайсе кампании GetPriceStatus
// -----------------------------------------------------------------------------
$jsonGetPriceStatus = $Main->Step2($campaign_id);

$date = date('dmy_His');
$fileGetPriceStatus = realpath(__DIR__ . '/../data/') . '/' . 'price_status_' . $date . '.json';
file_put_contents($fileGetPriceStatus, $jsonGetPriceStatus, FILE_APPEND);

$arrayGetPriceStatus = json_decode($jsonGetPriceStatus, true);

if ($arrayGetPriceStatus['response']['status'] == 'PROCESSED')
{
	$GetPriceStatusId = $arrayGetPriceStatus['response']['id'];
	$flag_step2 = true;
}
else
{
	$GetPriceStatus_id = 0;
	$flag_step2 = false;
}

start3:
// -----------------------------------------------------------------------------
// Шаг3 Создание отчёта по кампании CreateReport
// -----------------------------------------------------------------------------

$flag_step2 = true;
if ($flag_step2 == true)
{
	$jsonCreateReport = $Main->Step3($campaign_id);

	$date = date('dmy_His');
	$fileCreateReport = realpath(__DIR__ . '/../data/') . '/' . 'create_report_' . $date . '.json';
	file_put_contents($fileCreateReport, $jsonCreateReport, FILE_APPEND);

	$arrayCreateReport = json_decode($jsonCreateReport, true);
	$CreateReportId = $arrayCreateReport['response']['id'];
}
else
{
	$CreateReportId = 0;
}

start4:
// -----------------------------------------------------------------------------
// Шаг3 Создание отчёта по кампании GetReportStatus
// -----------------------------------------------------------------------------

$CreateReportId = '3062906';

$file = $Main->Step4($campaign_id, $CreateReportId);

//{"response":{"id":3062906,"status":"OK","createdAt":"2025-10-15T17:33:19+03:00","isSuccessfullyFinished":true,
//"startedAt":"2025-10-15T17:33:20+03:00","finishedAt":"2025-10-15T17:36:54+03:00","countErrorProducts":0,"countOkProducts":1}}


$a = 1;




