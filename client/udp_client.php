<?php

$client = new swoole_client(SWOOLE_SOCK_UDP);

if(!$client->connect('127.0.0.1', 9502, -1)) {
    exit('连接失败');
} 

$client->send("hello world\n");

echo $client->recv();
$client->close();
