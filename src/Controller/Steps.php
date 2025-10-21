<?php

namespace App\Controller;

class Steps
{
	public $file_data;
	private $file_data_url;
	private $file_data_url_csv;
	public $Ozon;
	public $Db;
	function __construct()
	{
		$date = ''; // date('dmy_His');
		$this->file_data = realpath(__DIR__ . '/../../data/') . '/' . 'products_' . $date . '.json';
		$this->file_data_url = realpath(__DIR__ . '/../../data/') . '/' . 'products_url_' . $date . '.json';
		$this->file_data_url_csv = realpath(__DIR__ . '/../../data/') . '/' . 'products_url_csv_' . $date . '.csv';
	}
	// подготовка json файла с продуктами
	function Step00()
	{
		$this->Db = new Db();
		
		$count = 2;
		
		$fetch = $this->Db->get_ozon_products_info_price_ozon_card($count);

		$products = [];

		foreach ( $fetch as $item )
		{
			$name = $item['name'] ?? null;
			$barcode = $item['barcode'] ?? '';
			$clean_barcode = str_replace('OZN', '', $barcode);

			$products[] = [
					'name' => $name,
					'cost' => 0,
					'id' => $clean_barcode,
					'yandex_model_id' =>  'https://www.ozon.ru/product/'.$clean_barcode
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
	function Step5($campaign_id, $report_id)
	{
		$Marketparser = new Marketparser();
		$result = $Marketparser->methodGetReportResults($campaign_id, $report_id);

		return $result;
	}

	// Шаг6 Получение списка отчётов кампании
	function Step6($campaign_id)
	{
		$Marketparser = new Marketparser();
		$result = $Marketparser->methodGetCampaignsReports($campaign_id);

		return $result;
	}

	// Шаг7 Обновление таблицы с товарами - установка найденных цен
	function Step7($json)
	{
		$arrayProducts = json_decode($json, true);

		$this->Db = new Db();
		
		
		$k = 0;
		
		for($i = 0; $i < count($arrayProducts); $i++)
		{
			$params['product_id'] = $arrayProducts[$i]['id'];
			$params['price_with_ozon_card'] = $arrayProducts[$i]['card_price'];

			if ($params['price_with_ozon_card'] != 0)
			{
				$result = $this->Db->update_ozon_product_info($params);
				$k++;
			}
		}

		

		return $k;
	}
	
	function StepListUrl()
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
					'id' => $clean_barcode,
					'yandex_model_id' =>  'https://www.ozon.ru/product/'.$clean_barcode
			];
		}
		
		// $json = json_encode(array_values($products), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		// $body = json_encode(['products' => $products], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		$body = json_encode([
				'products' => $products
		]);
		
		$data = $body;
		
		file_put_contents($this->file_data_url, $data);
		
		return $this->file_data_url;
	}
	
	function StepListUrlCSV()
	{
		$this->Db = new Db();
		$fetch = $this->Db->get_ozon_products_info_price_ozon_card();
		
		// Открываем файл для записи CSV
		$file = fopen($this->file_data_url_csv, 'w');
		
		// Записываем заголовки CSV
		fputcsv($file, ['name', 'cost', 'id', 'url']);
		
		foreach ($fetch as $item) {
			$name = $item['name'] ?? null;
			$barcode = $item['barcode'] ?? '';
			$clean_barcode = str_replace('OZN', '', $barcode);
			
			// Формируем строку для CSV
			$row = [
					'name' => $name,
					'cost' => 0,
					'id' => $clean_barcode,
					'url' => 'https://www.ozon.ru/product/' . $clean_barcode
			];
			
			// Записываем строку в CSV
			fputcsv($file, $row);
		}
		
		// Закрываем файл
		fclose($file);
		
		return $this->file_data_url_csv;
	}
	
}