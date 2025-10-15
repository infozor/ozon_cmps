<?php

namespace App\Controller;

use App\Controller\Steps;

class Main
{
	function __construct()
	{
		$a = 1;
	}
	function Step00()
	{
		$Steps = new Steps();
		// подготовка json файла с продуктами
		$step1 = $Steps->Step00();
		return $step1;
	}
	function Step01()
	{
		$Steps = new Steps();
		// Список кампаний
		$step1 = $Steps->Step01();
		return $step1;
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
	function Step3()
	{
		$Steps = new Steps();
		$step3 = $Steps->Step3();
		return $step3;
	}

	// Шаг4 Получение информации об отчёте
	function Step4()
	{
		$Steps = new Steps();
		$step4 = $Steps->Step4();
		return $step4;
	}

	// Шаг5 Получение результатов парсинга отчёта
	function Step5()
	{
		$Steps = new Steps();
		$step5 = $Steps->Step5();
		return $step5;
	}
	function Step6()
	{
		$Steps = new Steps();
		$step6 = $Steps->Step6();
		return $step6;
	}
}