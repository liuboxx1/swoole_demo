<?php
/**
 * Created by PhpStorm.
 * User: BeckLiu
 * Date: 2018/8/30
 * Time: 18:38
 */

class Redis
{
    public $redis;
    const IP = '127.0.0.1';
    const PORT = 6379;

    public function __construct()
    {
        $this->redis = new  Redis();
        $this->connect();
    }

    public function connect()
    {
        $this->redis->connect(static::IP, static::PORT);
        echo $this->redis->ping();
    }

}