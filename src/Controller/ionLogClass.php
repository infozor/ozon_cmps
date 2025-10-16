<?php
namespace App\Controller;

class ionLogClass
{
	private $root_path;
	
	function __construct($root_path)
	{
		$this->root_path = $root_path;
	}
	function logMethod($message = '')
	{
		$this->log('all', date('d.m.Y H:i:s') . ' ' . $message . "\n");
	}
	public function log($type, $message)
	{
		
		$path = $this->root_path;
		
		if (!file_exists($path))
		{
			mkdir($path);
		}
		
		$file = $path . '/' . $type . ".log.txt";
		return ( bool ) file_put_contents($file, $message, FILE_APPEND);
	}
}
