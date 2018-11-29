<?php

/**
 * 后台公共文件
 */
namespace app\admin\controller;

use think\Controller;

class Basics extends Controller
{

    public function header()
    {
        return  $this->display();
    }

    public function json($code,$message='',$data = array())
    {
        if(!is_numeric($code))
        {
            return "";
        }
        $result = array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        );

        echo json_encode($result);
        exit;
    }

    public function login() {
        return  $this->display();
    }
}
