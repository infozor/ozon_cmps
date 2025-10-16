<?php

namespace App\Controller;

use App\Controller\Config;

class Marketparser
{
	public $config;
	public $apiToken;
	public $apiMainUrl;
	public $apiUrl;
	public $file_data;
	public $conn;
	function __construct()
	{
		$Config = new Config();
		$this->config = $Config->get_data();
		$this->apiToken = $this->config['marketparser']['token'];
		$this->apiMainUrl = $this->config['marketparser']['api']['main_url'];

		$date = date('dmy_His');
		$this->file_data = realpath(__DIR__ . '/../../data/') . '/' . 'products_' . $date . '.json';

		$db_servername = "192.168.9.196";
		$db_username = "postgreadmin";
		$db_password = "postgreadmin";
		$db_name = "backoffice";
		$dbPort = '5432';

		$conn = new \PDO("pgsql:host=$db_servername;port=$dbPort;dbname=$db_name", $db_username, $db_password);
		$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		$this->conn = $conn;
	}
	function send_get($apiUrl)
	{
		$headers = [
				'Api-Key: ' . $this->apiToken,
				'Content-Type: application/json'
		];

		$queryString = '';

		$fullUrl = $apiUrl . ($queryString ? '?' . $queryString : '');

		$ch = curl_init($fullUrl);
		curl_setopt_array($ch, [
				CURLOPT_HTTPGET => true,
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_TIMEOUT => 30
		]);

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$error = curl_error($ch);

		curl_close($ch);

		if ($error)
		{
			// Обработка ошибки cURL
			// echo "Ошибка cURL: " . $error;
			$response = $error;
		}
		else
		{
			// Обработка успешного ответа
			// echo "HTTP код: " . $httpCode . "\n";
			// echo "Ответ: " . $response;
		}

		return $response;
	}
	function send_post($apiUrl, $body)
	{
		$headers = [
				'Api-Key: ' . $this->apiToken,
				'Content-Type: application/json'
		];

		$ch = curl_init($apiUrl);
		curl_setopt_array($ch, [
				CURLOPT_POST => true,
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_POSTFIELDS => $body,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_TIMEOUT => 30
		]);

		$response = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$error = curl_error($ch);

		curl_close($ch);

		if ($error)
		{
			// Обработка ошибки cURL
			// echo "Ошибка cURL: " . $error;
			$response = $error;
		}
		else
		{
			// Обработка успешного ответа
			// echo "HTTP код: " . $httpCode . "\n";
			// echo "Ответ: " . $response;
		}

		return $response;
	}
	function methodGetCampaigns()
	{
		$apiMethodPart[0] = $this->config['marketparser']['api']['methods']['ListCampaigns']['method_part0'];

		$apiUrl = $this->apiMainUrl . $apiMethodPart[0];

		$result = $this->send_get($apiUrl);

		return $result;
	}
	function methodUpdatePrice($campaign_id, $json_file_products)
	{

		// marketparser_step1_update_price.php
		$apiMethodPart[0] = $this->config['marketparser']['api']['methods']['UpdatePrice']['method_part0'];
		$apiMethodPart[1] = $this->config['marketparser']['api']['methods']['UpdatePrice']['method_part1'];

		//$CAMPAIGN_ID = '55312';
		
		$CAMPAIGN_ID = $campaign_id;

		$apiUrl = $this->apiMainUrl . $apiMethodPart[0] . $CAMPAIGN_ID . $apiMethodPart[1];

		/*
		 * $body = '{"products": [
		 * {
		 * "name": "НАКОНЕЧНИК рулевой левый на Geely Atlas Pro с 2021г. - по н.в.",
		 * "cost": 0,
		 * "id": "1712066954"
		 * },
		 * {
		 * "name": "НАКОНЕЧНИК рулевой правый на Geely Atlas Pro с 2021г. - по н.в.",
		 * "cost": 0,
		 * "id": "1712063965"
		 * },
		 * {
		 * "name": "ОПОРА промежуточная карданного вала на Great Wall Hover H6\/Haval H6\/Haval F7\/Haval F7X",
		 * "cost": 0,
		 * "id": "1712068692"
		 * }
		 * ]}';
		 */

		$body = $json_file_products;

		$result = $this->send_post($apiUrl, $body);

		return $result;
	}
	function methodGetPriceStatus($campaign_id)
	{
		$apiMethodPart[0] = $this->config['marketparser']['api']['methods']['GetPriceStatus']['method_part0'];
		$apiMethodVar[0] = $this->config['marketparser']['api']['methods']['GetPriceStatus']['method_var0'];
		$apiMethodPart[1] = $this->config['marketparser']['api']['methods']['GetPriceStatus']['method_part1'];

		//$CAMPAIGN_ID = '55312';
		
		$CAMPAIGN_ID = $campaign_id;

		$apiUrl = $this->apiMainUrl . $apiMethodPart[0] . $CAMPAIGN_ID . $apiMethodPart[1];

		$result = $this->send_get($apiUrl);

		return $result;
	}
	function methodCreateReport($campaign_id)
	{
		$apiMethodPart[0] = $this->config['marketparser']['api']['methods']['CreateReport']['method_part0'];
		$apiMethodVar[0] = $this->config['marketparser']['api']['methods']['CreateReport']['method_var0'];
		$apiMethodPart[1] = $this->config['marketparser']['api']['methods']['CreateReport']['method_part1'];

		//$CAMPAIGN_ID = '55312';
		$CAMPAIGN_ID = $campaign_id;

		$apiUrl = $this->apiMainUrl . $apiMethodPart[0] . $CAMPAIGN_ID . $apiMethodPart[1];

		$body = [];

		$result = $this->send_post($apiUrl, $body);

		return $result;
	}
	function methodGetReportStatus($campaign_id, $report_id)
	{
		$apiMethodPart[0] = $this->config['marketparser']['api']['methods']['GetReportStatus']['method_part0'];
		$apiMethodVar[0] = $this->config['marketparser']['api']['methods']['GetReportStatus']['method_var0'];
		$apiMethodPart[1] = $this->config['marketparser']['api']['methods']['GetReportStatus']['method_part1'];
		$apiMethodVar[1] = $this->config['marketparser']['api']['methods']['GetReportStatus']['method_var1'];
		$apiMethodPart[2] = $this->config['marketparser']['api']['methods']['GetReportStatus']['method_part2'];

		/*
		$CAMPAIGN_ID = '55312';
		$REPORT_ID = '3056408';
		*/

		$CAMPAIGN_ID = $campaign_id;
		$REPORT_ID = $report_id;
		
		$apiUrl = $this->apiMainUrl . $apiMethodPart[0] . $CAMPAIGN_ID . $apiMethodPart[1] . $REPORT_ID . $apiMethodPart[2];

		$result = $this->send_get($apiUrl);

		return $result;
	}
	function methodGetReportResults($campaign_id, $report_id)
	{
		$method = 'GetReportResults';

		$apiMethodPart[0] = $this->config['marketparser']['api']['methods'][$method]['method_part0'];
		$apiMethodVar[0] = $this->config['marketparser']['api']['methods'][$method]['method_var0'];
		$apiMethodPart[1] = $this->config['marketparser']['api']['methods'][$method]['method_part1'];
		$apiMethodVar[1] = $this->config['marketparser']['api']['methods'][$method]['method_var1'];
		$apiMethodPart[2] = $this->config['marketparser']['api']['methods'][$method]['method_part2'];

		/*
		 * $CAMPAIGN_ID = '55312';
		 *
		 * $REPORT_ID = '3056408';
		 */

		/*
		$CAMPAIGN_ID = '55310';
		$REPORT_ID = '3033811';
		*/
		
		$CAMPAIGN_ID = $campaign_id;
		$REPORT_ID = $report_id;
		

		$page_size = 100;

		$apiUrl = $this->apiMainUrl . $apiMethodPart[0] . $CAMPAIGN_ID . $apiMethodPart[1] . $REPORT_ID . $apiMethodPart[2] . '?per_page=' . $page_size;

		$result = $this->send_get($apiUrl);

		return $result;
	}
	
	// Шаг6 Получение списка отчётов кампании
	function methodGetCampaignsReports($campaign_id)
	{
		$method = 'GetCampaignsReports';

		$apiMethodPart[0] = $this->config['marketparser']['api']['methods'][$method]['method_part0'];
		$apiMethodVar[0] = $this->config['marketparser']['api']['methods'][$method]['method_var0'];
		$apiMethodPart[1] = $this->config['marketparser']['api']['methods'][$method]['method_part1'];

		// $CAMPAIGN_ID = '55312';
		//$CAMPAIGN_ID = '55310';

		// $REPORT_ID = '3056408';

		/*
		 * $CAMPAIGN_ID = '55310';
		 *
		 * $REPORT_ID = '3033811';
		 */
		
		$CAMPAIGN_ID = $campaign_id;

		$apiUrl = $this->apiMainUrl . $apiMethodPart[0] . $CAMPAIGN_ID . $apiMethodPart[1];

		$result = $this->send_get($apiUrl);

		return $result;
	}
}