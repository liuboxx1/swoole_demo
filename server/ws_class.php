<?php

class Ws {
    
    const HOST = '0.0.0.0';
    const PORT = 1433;
    public static $server;

    public function __construct() {
        static::$server = new swoole_websocket_server(static::HOST, static::PORT);
        
        static::$server->on('open', [$this, 'onOpen']); //监听连接

        static::$server->on('message', [$this, 'onMessage']);  //监听消息

	static::$server->on('close', [$this, 'onClose']);  //监听关闭连接

        static::$server->start();
    }

    public function onOpen($server, $request)
    {
        print_r($request->fd);
    }

    public function onMessage($server, $frame)
    {
        echo "receive from {$frame->fd} : {$frame->data}, opcode : {$frame->opcode}, fin : {$frame->finish} \n";
        $server->push($frame->fd, "服务器推送数据到客户端");
    }

    public function onClose($server, $fd)
    {
        echo "client {$fd} closed \n";
    }
    
}
$websocket = new Ws();

#呵呵呵呵呵