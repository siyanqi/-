<?php

/**
 * 后台公共文件
 */
namespace app\admin\controller;

use think\Controller;
use think\Request;

class Basics extends Controller
{
    public function __construct()
    {
        // 先调用父类的构造函数
        parent::__construct();
        // 获取当前管理员的ID
        $adminId = session('admin_id');
        // 验证登录
        if (!$adminId) {
            $this->redirect(url('Admin/Admin/login'));
        }


    }


    public function upload($path,$name){


        $file = request()->file($name);
        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move($path);
        if($info){
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            return array('info'=>$info->getSaveName(),'type'=>1);
        }else{
            // 上传失败获取错误信息
            return array('info'=>$file->getError(),'type'=>2);
        }
    }
}
