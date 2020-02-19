<?php

//创建Server对象，监听 127.0.0.1:9501端口
$serv = new Swoole\Server("127.0.0.1", 9501); 

//监听连接进入事件
$serv->on('Connect', function ($serv, $fd) {  
    echo "Client: Connect.\n";
});

//监听数据接收事件
$serv->on('Receive', function ($serv, $fd, $from_id, $data) {
  	/*
  	if($data > 5){
    	$num = 10;
    }else{
    	$num = 5;
    }
    */
    $serv->send($fd, "Server Send: ".$data);
  	echo $fd."- TCP客户端连接的唯一标识符:fd \n";
  	echo $from_id. "-TCP连接所在的Reactor线程ID:from_id \n";
  	// 关闭客户端的连接
  	$serv->close($fd);
});

//监听连接关闭事件
$serv->on('Close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

//启动服务器
$serv->start();