<?php

/**
 * 后台公共文件
 */
namespace app\admin\controller;

use app\admin\controller\Basics;


class Comment extends Basics
{
    public function index()
    {
        return  $this->fetch();
    }

    public function add()
    {
        return  $this->fetch();
    }



}
