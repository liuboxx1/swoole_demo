<?php

$server = new swoole_websocket_server("0.0.0.0", 1433);

//监听websocket连接打开事件
$server->on('open', 'onOpen');
function onOpen($server, $request) {
    print_r($request->fd);
}

//监听ws消息事件
$server->on('message', function (swoole_websocket_server $server, $frame) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $server->push($frame->fd, "服务器推送数据到客户端");
});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();
