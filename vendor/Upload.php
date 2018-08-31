<?php
/**
 * Created by PhpStorm.
 * User: BeckLiu
 * Date: 2018/8/31
 * Time: 10:39
 */

class Upload
{
    static private $instance;
    private $config;
    private function __construct($config)
    {
        $this->config = $config;
    }
    //防止被克隆
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }
    static public function getInstance($config)
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self($config);
        }
        return self::$instance;
    }

    public function uploadImg($file)
    {

    }

}