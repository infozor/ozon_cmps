<?php

namespace App\Controller;

class Steps
{
	public $file_data;
	public $Ozon;
	public $Db;
	function __construct()
	{
		$date = date('dmy_His');
		$this->file_data = realpath(__DIR__ . '/../../data/') . '/' . 'products_' . $date . '.json';
	}
	// подготовка json файла с продуктами
	function Step00()
	{
		$this->Db = new Db();
		$fetch = $this->Db->get_ozon_products_info_price_ozon_card();

		$products = [];

		foreach ( $fetch as $item )
		{
			$name = $item['name'] ?? null;
			$barcode = $item['barcode'] ?? '';
			$clean_barcode = str_replace('OZN', '', $barcode);

			$products[] = [
					'name' => $name,
					'cost' => 0,
					'id' => $clean_barcode
			];
		}

		// $json = json_encode(array_values($products), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		// $body = json_encode(['products' => $products], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		$body = json_encode([
				'products' => $products
		]);

		/*
		 * $body = '{
		 * "products": [
		 * {
		 * "name": "product-123",
		 * "cost": 0,
		 * "id": "123"
		 * }
		 * ]
		 * }';
		 */

		// $data = $body;

		$data = $body;

		file_put_contents($this->file_data, $data, FILE_APPEND);

		return $this->file_data;
	}

	// Список кампаний
	function Step01()
	{
		$Marketparser = new Marketparser();
		$result = $Marketparser->methodGetCampaigns();

		return $result;
	}

	// Шаг1 обновление прайса
	function Step1($campaign_id, $json_file_products)
	{
		$Marketparser = new Marketparser();
		$result = $Marketparser->methodUpdatePrice($campaign_id, $json_file_products);

		return $result;
	}

	// Шаг2 Получение информации о прайсе кампании
	function Step2($campaign_id)
	{
		$Marketparser = new Marketparser();
		$result = $Marketparser->methodGetPriceStatus($campaign_id);

		return $result;
	}

	// Шаг3 Создание отчёта по кампании
	function Step3($campaign_id)
	{
		$Marketparser = new Marketparser();
		$result = $Marketparser->methodCreateReport($campaign_id);

		return $result;
	}
	function Step4($campaign_id, $report_id)
	{
		$Marketparser = new Marketparser();
		$result = $Marketparser->methodGetReportStatus($campaign_id, $report_id);

		return $result;
	}
	function Step5()
	{
		$Marketparser = new Marketparser();
		$result = $Marketparser->methodGetReportResults();

		return $result;
	}
	function Step6()
	{
		$Marketparser = new Marketparser();
		$result = $Marketparser->methodGetCampaignsReports();

		return $result;
	}
}