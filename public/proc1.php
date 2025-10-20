<?php
$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';

use App\Controller\Main;
use App\Controller\ionLogClass;


date_default_timezone_set('Europe/Moscow');

$Main = new Main();
function get_logs_path()
{
	$path = realpath(__DIR__ . '/../log/');
	return $path;
}

$LogClass = new ionLogClass(get_logs_path());
function delete_files($directory)
{
	if (is_dir($directory))
	{

		$files = glob($directory . "/*.json");
		foreach ( $files as $file )
		{
			if (is_file($file))
			{
				unlink($file); // удаляем файл
			}
		}
	}
	else
	{
	}
}

// $campaign_id = '55310';
$campaign_id = '55312';

// goto start5;
// goto step01;

//goto start7;
//goto start5_1;

$LogClass->logMethod("------ start-> campaign_id:" . $campaign_id);

$directory = realpath(__DIR__ . '/../data/');

delete_files($directory);

// goto start6_1;

// -----------------------------------------------------------------------------
// подготовка json файла с товарами
// -----------------------------------------------------------------------------
$LogClass->logMethod("подготовка json файла с товарами");
$file_products = $Main->Step00();
// $file_products = 'D:\site_next\ozonparsemark\data/products_151025_140228.json';
$json_file_products = file_get_contents($file_products);

$array_file_products = json_decode($json_file_products, true);

// goto finish;

// -----------------------------------------------------------------------------
// получить список кампаний ListCampaigns
// -----------------------------------------------------------------------------
$LogClass->logMethod("Шаг01 получить список кампаний");
$json_list_campaigns = $Main->Step01();

$array_list_campaigns = json_decode($json_list_campaigns, true);

$date = ''; // date('dmy_His');
$file_data = realpath(__DIR__ . '/../data/') . '/' . 'campaigns_' . $date . '.json';
file_put_contents($file_data, $json_list_campaigns, FILE_APPEND);

/*
 * step01:
 * $file_products = 'D:\site_next\ozonparsemark\data/products_.json';
 * $json_file_products = file_get_contents($file_products);
 */

// -----------------------------------------------------------------------------
// Шаг1 Обновить (перезалить) прайс лист с товарами
// UpdatePrice
// -----------------------------------------------------------------------------
$LogClass->logMethod("Шаг1 Обновить (перезалить) прайс лист с товарами");

$file = $Main->Step1($campaign_id, $json_file_products);

// start2:
// -----------------------------------------------------------------------------
// Шаг2 Получение информации о прайсе кампании
// GetPriceStatus
// -----------------------------------------------------------------------------
$LogClass->logMethod("Шаг2 Получение информации о прайсе кампании");

$count_iter = 10;

for($i = 0; $i < $count_iter; $i++)
{

	$jsonGetPriceStatus = $Main->Step2($campaign_id);

	$date = ''; // date('dmy_His');
	$fileGetPriceStatus = realpath(__DIR__ . '/../data/') . '/' . 'price_status_' . $date . '.json';
	file_put_contents($fileGetPriceStatus, $jsonGetPriceStatus, FILE_APPEND);

	$arrayGetPriceStatus = json_decode($jsonGetPriceStatus, true);

	$LogClass->logMethod('проверка: ' . ($i + 1) . " статус: " . $arrayGetPriceStatus['response']['status']);

	if ($arrayGetPriceStatus['response']['status'] == 'PROCESSED')
	{
		$GetPriceStatusId = $arrayGetPriceStatus['response']['id'];
		$flag_step2 = true;
		break;
	}
	else
	{
		if ($arrayGetPriceStatus['response']['status'] == 'READY_TO_BE_PARSED')
		{
		}
	}
}
if (!($arrayGetPriceStatus['response']['status'] == 'PROCESSED'))
{
	$GetPriceStatus_id = 0;
	$flag_step2 = false;
	$LogClass->logMethod("не получена");
	var_dump($arrayGetPriceStatus);
	exit();
}

// start3:
// -----------------------------------------------------------------------------
// Шаг3 Создание отчёта по кампании
// CreateReport
// -----------------------------------------------------------------------------

$LogClass->logMethod("Шаг3 Создание отчёта по кампании");

// $flag_step2 = true;
if ($flag_step2 == true)
{
	try
	{
		$jsonCreateReport = $Main->Step3($campaign_id);

		$date = ''; // date('dmy_His');
		$fileCreateReport = realpath(__DIR__ . '/../data/') . '/' . 'create_report_' . $date . '.json';
		file_put_contents($fileCreateReport, $jsonCreateReport, FILE_APPEND);

		$arrayCreateReport = json_decode($jsonCreateReport, true);

		$CreateReportId = $arrayCreateReport['response']['id'];

		if (isset($arrayCreateReport['response']['id']))
		{
			$CreateReportId = $arrayCreateReport['response']['id'];
		}
		else
		{

			echo "ID не найден в массиве";
			var_dump($arrayCreateReport);
			exit();
		}

		$flag_step3 = true;
		$LogClass->logMethod("создан отчёт ReportIdId: " . $CreateReportId);
	}
	catch ( Exception $e )
	{

		echo "Ошибка: " . $e->getMessage();
		exit();
	}
}
else
{
	$CreateReportId = 0;
	$flag_step3 = false;
}

// start4:
// -----------------------------------------------------------------------------
// Шаг4 Получение информации об отчёте
// GetReportStatus
// -----------------------------------------------------------------------------

$LogClass->logMethod("Шаг4 Получение информации об отчёте");

// $CreateReportId = '3062906';

$report_id = $CreateReportId;

$count_iter = 10;

for($i = 0; $i < $count_iter; $i++)
{
	try
	{

		$jsonGetReportStatus = $Main->Step4($campaign_id, $report_id);

		$date = ''; // date('dmy_His');
		$fileGetReportStatus = realpath(__DIR__ . '/../data/') . '/' . 'report_status_' . $date . '.json';
		file_put_contents($fileGetReportStatus, $jsonGetReportStatus, FILE_APPEND);

		$arrayGetReportStatus = json_decode($jsonGetReportStatus, true);

		$ReportStatus = $arrayGetReportStatus['response']['status'];

		$LogClass->logMethod('проверка: ' . ($i + 1) . " статус: " . $ReportStatus);

		if ($ReportStatus == 'OK')
		{

			$flag_step4 = true;
			break;
		}
		else
		{
			$flag_step4 = false;
		}
	}
	catch ( Exception $e )
	{

		echo "Ошибка: " . $e->getMessage();
		exit();
	}
	sleep(60);
}

if ($flag_step4 == false)
{
	$LogClass->logMethod("Не хватило времени на ожидание, парсинг не закончен");
	$LogClass->logMethod("Программа завершена с ошибками");
	exit();
}
start5:
// -----------------------------------------------------------------------------
// Шаг5 Получение результатов парсинга отчёта
// GetReportResults
// -----------------------------------------------------------------------------

$LogClass->logMethod("Шаг5 Получение результатов парсинга отчёта");

// $CreateReportId = '3062906';
// $CreateReportId = '3069600'; --- плохой отчет СЫР БОР!!!

// $CreateReportId = '3074421';

$report_id = $CreateReportId;

$jsonGetReportResult = $Main->Step5($campaign_id, $report_id);

$date = ''; // date('dmy_His');
$fileGetReportResult = realpath(__DIR__ . '/../data/') . '/' . 'report_results_' . $date . '.json';
file_put_contents($fileGetReportResult, $jsonGetReportResult, FILE_APPEND);

start5_1:

//закомментировать
//$jsonGetReportResult = file_get_contents('D:\site_next\ozonparsemark\data\report_results_.json');




$arrayGetReportResult = json_decode($jsonGetReportResult, true);


/*
 * if ($arrayGetReportResult['response']['total'] == 1)
 * {
 * $offers = $arrayGetReportResult['response']['products'][0]['offers'];
 * }
 */

// $offers = $arrayGetReportResult['response']['products'][0]['ourId'];

$product = [];
$products = $arrayGetReportResult['response']['products'];

$k = 0;

for($i = 0; $i < count($products); $i++)
{
	$offers = $products[$i]['offers'];

	if ($products[$i]['countOffers'] == '1')
	{

		$ourId = $products[$i]['ourId'];
		
		// $offer = $offers[0];

		// ['ourId']
		// $productRep = $arrayGetReportResult['response']['products'][$i];
		$test_modelId = $offers[0]['modelId'] ?? null;

		if ($test_modelId != null)
		{
			$product[$k]['id'] = $offers[0]['modelId'] ?? null;
			$product[$k]['card_price'] = $offers[0]['price_details']['card_price'] ?? null;
		}

		// $product[$i]['card_price'] = $offers[$i]['price_details']['card_price'];
		$k++;
	}
}

$jsonProductsResult = json_encode($product);

$date = ''; // date('dmy_His');
$fileProductsResult = realpath(__DIR__ . '/../data/') . '/' . 'products_result_' . $date . '.json';
file_put_contents($fileProductsResult, $jsonProductsResult, FILE_APPEND);

// $a = 1;
//exit();
// -----------------------------------------------------------------------------
// Шаг6 Получение списка отчётов кампании
// GetCampaignsReports
// -----------------------------------------------------------------------------
$LogClass->logMethod("Шаг6 Получение списка отчётов кампании");

start6:
$jsonGetCampaignsReports = $Main->Step6($campaign_id);
$date = ''; // date('dmy_His');
$fileGetCampaignsReports = realpath(__DIR__ . '/../data/') . '/' . 'campaign_reports_' . $date . '.json';
file_put_contents($fileGetCampaignsReports, $jsonGetCampaignsReports, FILE_APPEND);

// $jsonGetCampaignsReports = file_get_contents('D:\site_next\ozonparsemark\data\campaign_reports_161025_094258.json');

$arrayGetCampaignsReports = json_decode($jsonGetCampaignsReports, true);

start7:

// -----------------------------------------------------------------------------
// //Шаг7 Обновление таблицы с товарами - установка найденных цен
//
// -----------------------------------------------------------------------------

$LogClass->logMethod("Шаг7 Обновление таблицы с товарами - установка найденных цен");

$date = '';
$fileProductsResult = realpath(__DIR__ . '/../data/') . '/' . 'products_result_' . $date . '.json';
$json_file_products = file_get_contents($fileProductsResult);

$k = $Main->Step7($json_file_products);

$LogClass->logMethod("Обновлено " . $k . ' товаров');

$LogClass->logMethod("Программа завершена");
$LogClass->logMethod("------ finish <- campaign_id:" . $campaign_id);

echo 'finish';

//finish:
//$a = 1;