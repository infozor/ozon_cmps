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
		//подготовка json файла с продуктами
		$step1 = $Steps->Step00();
		return $step1;
	}
	
	function Step01()
	{
		$Steps = new Steps();
		//Список кампаний
		$step1 = $Steps->Step01();
		return $step1;
	}
	function Step1()
	{
		$Steps = new Steps();
		$step1 = $Steps->Step1();
		return $step1;
	}
	
	//Шаг2 Получение информации о прайсе кампании
	function Step2()
	{
		$Steps = new Steps();
		$step2 = $Steps->Step2();
		return $step2;
	}
	
	// Шаг3 Создание отчёта по кампании
	function Step3()
	{
		$Steps = new Steps();
		$step2 = $Steps->Step3();
		return $step2;
	}
}