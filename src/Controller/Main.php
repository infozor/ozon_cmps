<?php

namespace App\Controller;
use App\Controller\Steps;

class Main
{
	
	function __construct()
	{
		$a = 1;
	}
	function Step0()
	{
		$Steps = new Steps();
		//подготовка json файла с продуктами
		$step1 = $Steps->Step0();
		return $step1;
	}
	function Step1()
	{
		$Steps = new Steps();
		//подготовка json файла с продуктами
		$step1 = $Steps->Step1();
		return $step1;
	}
}