<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);
$callback = function($msg){
	echo ' [x] Received ', $msg->body, "\n";
	sleep(substr_count($msg->body, '.'));
	 echo " [x] Done\n";
};
$channel->basic_consume('hello','',false,true,false,false,$callback);
while(count($channel->callbacks)){
	$channel->wait();
}