<?php

namespace App\Controller;

use App\Controller\Steps;

class Main
{
	function __construct()
	{
		$a = 1;
	}
	function Step00minus2($sku)
	{
		$Steps = new Steps();
		// синий3 берём данные для products из БД
		$step = $Steps->Step00minus2($sku);
		return $step;
	}
	
	function Step00minus1($sheetData)
	{
		$Steps = new Steps();
		// жёлтый2 заливка xlsx в БД
		$step = $Steps->Step00minus1($sheetData);
		return $step;
	}
	function Step00()
	{
		$Steps = new Steps();
		// подготовка json файла с продуктами
		$step = $Steps->Step00();
		return $step;
	}
	function Step01()
	{
		$Steps = new Steps();
		// Список кампаний
		$step = $Steps->Step01();
		return $step;
	}
	function Step1($campaign_id, $json_file_products)
	{
		$Steps = new Steps();
		$step1 = $Steps->Step1($campaign_id, $json_file_products);
		return $step1;
	}

	// Шаг2 Получение информации о прайсе кампании
	function Step2($campaign_id)
	{
		$Steps = new Steps();
		$step2 = $Steps->Step2($campaign_id);
		return $step2;
	}

	// Шаг3 Создание отчёта по кампании
	function Step3($campaign_id)
	{
		$Steps = new Steps();
		$step3 = $Steps->Step3($campaign_id);
		return $step3;
	}

	// Шаг4 Получение информации об отчёте
	function Step4($campaign_id, $report_id)
	{
		$Steps = new Steps();
		$step4 = $Steps->Step4($campaign_id, $report_id);
		return $step4;
	}

	// Шаг5 Получение результатов парсинга отчёта
	function Step5($campaign_id, $report_id)
	{
		$Steps = new Steps();
		$step5 = $Steps->Step5($campaign_id, $report_id);
		return $step5;
	}
	
	// Шаг6 Получение списка отчётов кампании
	function Step6($campaign_id)
	{
		$Steps = new Steps();
		$step6 = $Steps->Step6($campaign_id);
		return $step6;
	}
	
	//Шаг7 Обновление таблицы с товарами - установка найденных цен
	function Step7($json)
	{
		$Steps = new Steps();
		$step6 = $Steps->Step7($json);
		return $step6;
	}
	
	function StepListUrl()
	{
		$Steps = new Steps();
		// формирование списка url с продуктами
		$step1 = $Steps->StepListUrl();
		return $step1;
	}
	
	function StepListUrlCSV()
	{
		$Steps = new Steps();
		// формирование списка csv с продуктами
		$step1 = $Steps->StepListUrlCSV();
		return $step1;
	}
}