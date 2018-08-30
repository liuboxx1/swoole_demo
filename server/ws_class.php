<?php

class Ws {
    
    const HOST = '0.0.0.0';
    const PORT = 1433;
    public static $server;
    public static $redis;

    public function __construct($redis) {

        static::$redis = $redis;

        static::$server = new swoole_websocket_server(static::HOST, static::PORT);
        
        static::$server->on('open',     [$this, 'onOpen']); //监听连接

        static::$server->on('message',  [$this, 'onMessage']);  //监听消息

	    static::$server->on('close',    [$this, 'onClose']);  //监听关闭连接

        static::$server->start();
    }

    public function onOpen($server, $request)
    {
        static::$redis->sadd('fd', $request->fd);
        print_r($request->fd);
    }

    public function onMessage($server, $frame)
    {
        echo "receive from {$frame->fd} : {$frame->data}, opcode : {$frame->opcode}, fin : {$frame->finish} \n";
        $fdArray = static::$redis->smember('fd');
        foreach ($fdArray as $value) {
            $server->push($value, $frame->data . '<br />');
        }
//        $server->push($frame->fd, $frame->data);
    }

    public function onClose($server, $fd)
    {
        echo "client {$fd} closed \n";
        static::$redis->srem('fd', $fd);
    }
}
require_once '../vendor/Redis.php';
$ws = new Ws(new Redis_cli());