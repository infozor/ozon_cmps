<?php

namespace App\Controller;
use App\Controller\Check;

class Main
{
	
	function __construct()
	{
		$a = 1;
	}
	function Test()
	{
		$Check = new Check();
		$test = $Check->Test();
		return $test;
	}
	
}