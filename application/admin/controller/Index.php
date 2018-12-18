<?php

/**
 * 后台公共文件
 */
namespace app\admin\controller;

use app\admin\controller\Basics;


class Index extends Basics
{
    public function index()
    {
        return  $this->fetch('Index/index');
    }

    public function welcome()
    {
        return  $this->fetch('Index/welcome');
    }


}
