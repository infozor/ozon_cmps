<?php
/**
 * User: ion
 * Date: 23 янв. 2025 г.
 * Time: 17:27:00
 */



$path = realpath(__DIR__ . '/../vendor/');
require $path . '/' . 'autoload.php';


use App\Controller\Process;






$host = "192.168.9.86";
$port = 25005;

set_time_limit(0);


$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
// bind socket to port
$result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");

// start listening for connections
$result = socket_listen($socket, 3) or die("Could not set up socket listener\n");

while ( true )
{
	
	
	
	// accept incoming connections
	// spawn another socket to handle communication
	$spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
	// read client input
	$input = socket_read($spawn, 1024) or die("Could not read input\n");
	// clean up input string
	$input = trim($input);

	$Process = new Process();
	
	
	
	//$output = 'price:'.$price;
	
	
	$campaign_id = $input;
	//$campaign_id = '55312';
	
	$result = $Process->run($campaign_id);
	 
	
	
	$output = 'parse prices: '.$result;
	
	
	socket_write($spawn, $output, strlen($output)) or die("Could not write output\n");
	// close sockets
	socket_close($spawn);

}

socket_close($socket);