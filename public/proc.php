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

$campaign_id = '55310';
$file = $Main->Step1($campaign_id, $json_file_products);

$a = 1;

