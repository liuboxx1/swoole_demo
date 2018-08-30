<?php

$serv = new swoole_server('127.0.0.1', 9502, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);

$serv->on('Packet', function($serv, $data, $clientInfo){
    $serv->sendto($clientInfo['address'], $clientInfo['port'], "Server ".$data);
    echo $data . "\n";   
};
//启动服务器
$serv->start();


