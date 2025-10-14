<?php

namespace App\Controller;
use App\Controller\Steps;

class Main
{
	
	function __construct()
	{
		$a = 1;
	}
	function Step1()
	{
		$Steps = new Steps();
		$step1 = $Steps->Step1();
		return $step1;
	}
	
}