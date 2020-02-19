<?php

$http = new Swoole\Http\Server("0.0.0.0", 9501);

$http->on('request', function ($request, $response) {
    if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
        return $response->end();
    }
  
  	// list($controller, $action) = explode('/', trim($request->server['request_uri'], '/'));
    //根据 $controller, $action 映射到不同的控制器类和方法javascript:;
    // (new $contoller)->$action($request, $response);
  
    var_dump($request->get, $request->post);
    $response->header("Content-Type", "text/html; charset=utf-8");
    $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
});

$http->start();