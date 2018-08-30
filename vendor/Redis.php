<?php
/**
 * Created by PhpStorm.
 * User: BeckLiu
 * Date: 2018/8/30
 * Time: 18:38
 */

class Redis_cli
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
        $this->redis->select(0);
    }
    public function sadd($key, $value)
    {
        $this->redis->sAdd($key, $value);
    }
    public function srem($key, $value)
    {
        $this->redis->sRem($key, $value);
    }
    public function smember($key)
    {
        return $this->redis->sMembers($key);
    }

}
