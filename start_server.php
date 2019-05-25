<?php
//你玩篮球像蔡徐坤
use Workerman\Worker;
require_once __DIR__ . '/vendor/autoload.php';
$cxk_worker = new Worker("tcp://0.0.0.0:2333");
$cxk_worker->name = 'CXK Server';
$cxk_worker->count = 23;
$cxk_worker->onConnect = function($connection)
{
	$connection->id = '[W'.$connection->worker->id.'|C'.$connection->id;
	//避免缓冲区爆掉
	$connection->maxSendBufferSize = 6*1024*1024;
    for($x=1; $x<=294; $x++){
		$connection->send("\033[2J\033[H");
		$connection->send(str_replace("\n","\r\n",file_get_contents('pic/'.sprintf("%03d",$x).'.txt')));
        usleep(100000);
    }
	$connection->close("\r\n"."You play basketball like CXK."."\r\n");
};
$cxk_worker->onBufferFull = function($connection)
{
    echo "[ClientID:".$connection->id."] BufferFull".PHP_EOL;
};
$cxk_worker->onBufferDrain = function($connection)
{
	echo "[ClientID:".$connection->id."] BufferDrain".PHP_EOL;
};
$cxk_worker->onMessage = function($connection, $data)
{
	return ;
};

if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}