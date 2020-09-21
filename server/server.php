#!/usr/bin/env php
<?php

declare(strict_types=1);

require_once __DIR__.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

use Swoole\{WebSocket, Http};

$http = new WebSocket\Server("0.0.0.0", 9501);

$http->on(
    "start",
    function (WebSocket\Server $http) {
        echo "Swoole HTTP WebSocket server is started.\n";
    }
);
$http->on(
    "request",
    function (Http\Request $request, Http\Response $response) {
        $response->header('Content-Type', 'application/json');
        $response->end(json_encode(['name'=> 'ws-chat','date' => date('Y-m-d H:i:s')]));
    }
);

$http->on('open', function(WebSocket\Server $server, Swoole\Http\Request $request) {
    echo "connection open: {$request->fd}\n";
    $request->
    $server->tick(1000, function() use ($server, $request) {
        $server->push($request->fd, json_encode(["hello", time()]));
    });
});

$http->on('message', function(WebSocket\Server $server, WebSocket\Frame $frame) {
    echo "received message: {$frame->data}\n";
    $server->push($frame->fd, json_encode(["hello", time()]));
});

$http->on('close', function(WebSocket\Server $server, int $fd) {
    echo "connection close: {$fd}\n";
});

$http->start();
