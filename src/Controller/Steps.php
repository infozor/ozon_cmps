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
	//подготовка json файла с продуктами
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
		
		//$json = json_encode(array_values($products), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
		$body = json_encode(['products' => $products], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

		/*
		$body = '{
  "products": [
    {
      "name": "product-123",
      "cost": 0,
      "id": "123"
    }
   ]
  }';
  */

		//$data = $body;
		
		$data = $body;

		file_put_contents($this->file_data, $data, FILE_APPEND);

		return $this->file_data;
	}
	
	//Список кампаний
	function Step01()
	{
		$Marketparser = new Marketparser();
		$result = $Marketparser->methodGetCampaigns();
		
		return $result; 
	}
	
	function Step1()
	{
		
		$Marketparser = new Marketparser();
		$result = $Marketparser->methodUpdatePrice();
		
		return $result;
		
	}
	
	//Шаг2 Получение информации о прайсе кампании
	function Step2()
	{
		
		$Marketparser = new Marketparser();
		$result = $Marketparser->methodGetPriceStatus();
		
		return $result;
		
	}
	
	// Шаг3 Создание отчёта по кампании
	function Step3()
	{
		
		$Marketparser = new Marketparser();
		$result = $Marketparser->methodCreateReport();
		
		return $result;
		
	}
	
	function Step4()
	{
		
		$Marketparser = new Marketparser();
		$result = $Marketparser->methodGetReportStatus();
		
		return $result;
		
	}
	
	function Step5()
	{
		
		$Marketparser = new Marketparser();
		$result = $Marketparser->methodGetReportResults();
		
		return $result;
		
	}
}