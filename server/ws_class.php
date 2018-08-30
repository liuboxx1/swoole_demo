<?php

class Ws {
    
    const HOST = '0.0.0.0';
    const PORT = 1433;
    public static $server;

    public function __construct($redis) {
        static::$server = new swoole_websocket_server(static::HOST, static::PORT);
        
        static::$server->on('open',     [$this, 'onOpen', $redis]); //监听连接

        static::$server->on('message',  [$this, 'onMessage']);  //监听消息

	    static::$server->on('close',    [$this, 'onClose', $redis]);  //监听关闭连接

        static::$server->start();
    }

    public function onOpen($server, $request, $redis)
    {
        $redis->sadd('fd', $request->fd);
        print_r($request->fd);
    }

    public function onMessage($server, $frame)
    {
        echo "receive from {$frame->fd} : {$frame->data}, opcode : {$frame->opcode}, fin : {$frame->finish} \n";
        $server->push($frame->fd, $frame->data);
    }

    public function onClose($server, $fd, $redis)
    {
        echo "client {$fd} closed \n";
        $redis->srem('fd', $fd);
    }
}
require_once '../vendor/Redis.php';
$ws = new Ws(new Redis_cli());