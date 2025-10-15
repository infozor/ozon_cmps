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

goto start;

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


start:
// -----------------------------------------------------------------------------
// Шаг2 Получение информации о прайсе кампании GetPriceStatus
// -----------------------------------------------------------------------------
$jsonGetPriceStatus = $Main->Step2($campaign_id);

$date = date('dmy_His');
$file_data2 = realpath(__DIR__ . '/../data/') . '/' . 'price_status_' . $date . '.json';
file_put_contents($file_data2, $jsonGetPriceStatus, FILE_APPEND);

$arrayGetPriceStatus = json_decode($jsonGetPriceStatus, true);

if ($arrayGetPriceStatus['response']['status'] == 'PROCESSED')
{
	$GetPriceStatus_id = $arrayGetPriceStatus['response']['id'];
	$flag_step2 = true;
}
else
{
	$GetPriceStatus_id = 0;
	$flag_step2 = false;
}


//{"response":{"id":2534248,"createdAt":"2025-10-15T16:01:20+03:00","status":"PROCESSED",
//"countNotEmptyRows":32,"countFoundDuplicatedRows":0,"isSuccessfullyProcessed":true}}

$a = 1;




