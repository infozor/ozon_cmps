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

goto start6_1;

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
// Шаг1 Обновить (перезалить) прайс лист с товарами
// UpdatePrice
// -----------------------------------------------------------------------------

$file = $Main->Step1($campaign_id, $json_file_products);

start2:
// -----------------------------------------------------------------------------
// Шаг2 Получение информации о прайсе кампании
// GetPriceStatus
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
// Шаг3 Создание отчёта по кампании
// CreateReport
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
	$flag_step3 = true;
}
else
{
	$CreateReportId = 0;
	$flag_step3 = false;
}

start4:
// -----------------------------------------------------------------------------
// Шаг4 Получение информации об отчёте
// GetReportStatus
// -----------------------------------------------------------------------------

$CreateReportId = '3062906';

$report_id = $CreateReportId;

$jsonGetReportStatus = $Main->Step4($campaign_id, $report_id);

$date = date('dmy_His');
$fileGetReportStatus = realpath(__DIR__ . '/../data/') . '/' . 'report_status_' . $date . '.json';
file_put_contents($fileGetReportStatus, $jsonGetReportStatus, FILE_APPEND);

$arrayGetReportStatus = json_decode($jsonGetReportStatus, true);

$ReportStatus = $arrayGetReportStatus['response']['status'];

if ($ReportStatus == 'OK')
{
	$flag_step4 = true;
}
else
{
	$flag_step4 = false;
}

start5:
// -----------------------------------------------------------------------------
// Шаг5 Получение результатов парсинга отчёта
// GetReportResults
// -----------------------------------------------------------------------------

$CreateReportId = '3062906';
$report_id = $CreateReportId;

$jsonGetReportResult = $Main->Step5($campaign_id, $report_id);

$date = date('dmy_His');
$fileGetReportResult = realpath(__DIR__ . '/../data/') . '/' . 'report_results_' . $date . '.json';
file_put_contents($fileGetReportResult, $jsonGetReportResult, FILE_APPEND);

start5_1:
$jsonGetReportResult = file_get_contents('D:\site_next\ozonparsemark\data\report_results_151025_181758.json');

$arrayGetReportResult = json_decode($jsonGetReportResult, true);

if ($arrayGetReportResult['response']['total'] == 1)
{
	$offers = $arrayGetReportResult['response']['products'][0]['offers'];
}

$product = [];

for($i = 0; $i < count($offers); $i++)
{
	$product[$i]['id'] = $offers[$i]['modelId'];
	$product[$i]['card_price'] = $offers[$i]['price_details']['card_price'];
}

$jsonProductsResult = json_encode($product);

$date = date('dmy_His');
$fileProductsResult = realpath(__DIR__ . '/../data/') . '/' . 'products_result_' . $date . '.json';
file_put_contents($fileProductsResult, $jsonProductsResult, FILE_APPEND);

$a = 1;

// -----------------------------------------------------------------------------
// Шаг6 Получение результатов парсинга отчёта
// GetCampaignsReports
// -----------------------------------------------------------------------------

start6:
$jsonGetCampaignsReports = $Main->Step6($campaign_id);
$date = date('dmy_His');
$fileGetCampaignsReports = realpath(__DIR__ . '/../data/') . '/' . 'campaign_reports_' . $date . '.json';
file_put_contents($fileGetCampaignsReports, $jsonGetCampaignsReports, FILE_APPEND);

start6_1:

$jsonGetCampaignsReports = file_get_contents('D:\site_next\ozonparsemark\data\campaign_reports_161025_094258.json');

$arrayGetCampaignsReports = json_decode($jsonGetCampaignsReports, true);

$a = 1; 
