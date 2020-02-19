<?php

$serv = new Swoole\Server("0.0.0.0", 9501);
$serv->set(array(
    'worker_num' => 2,
    'task_worker_num' => 2,
));
$serv->on('pipeMessage', function($serv, $src_worker_id, $data) {
    echo "#{$serv->worker_id} message from #$src_worker_id: $data\n";
  	//$serv->send(2, "#{$serv->worker_id} message from #$src_worker_id: $data\n");
});
$serv->on('task', function ($serv, $task_id, $reactor_id, $data){
  	$serv->finish("Done");
    //var_dump($task_id, $from_id, $data);
  	//var_dump($serv);
});

$serv->on('finish', function ($serv, $fd, $reactor_id){
	$serv->send($fd, 'Done');
});

$serv->on('receive', function (swoole_server $serv, $fd, $reactor_id, $data) {
    if (trim($data) == 'task')
    {
        $serv->task("async task coming");
    }
    else
    {
        $worker_id = 1 - $serv->worker_id;
      	echo $worker_id . "->worker_id\n";
      	echo $fd . "->fd\n";
        $serv->sendMessage($data, $worker_id);
    }
});

$serv->start();
