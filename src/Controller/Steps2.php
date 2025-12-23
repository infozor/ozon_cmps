<?php

namespace App\Controller;

class Steps2
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
	function Step00minus3($products_uploads_id, $sheetData)
	{
		$this->walk($products_uploads_id, $sheetData);
	}
	function walk($products_uploads_id, $sheetData)
	{
		$this->Db = new Db();

		for($i = 0; $i < count($sheetData); $i++)
		{
			if ($i > 1)
			{
				$data = $sheetData[$i];

				$params['products_uploads_id'] = $products_uploads_id;
				$params['sku'] = $data['A'];
				$params['name'] = $data['B'];
				$params['part_number'] = $data['C'];

				$this->Db->insert_avz_products($params);
			}
		}
	}
}