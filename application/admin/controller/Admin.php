<?php

/**
 * 后台公共文件
 */
namespace app\admin\controller;

use app\admin\controller\Basics;
use think\Controller;
use think\Db;


class Admin extends Controller
{
    public function header()
    {
        return  $this->fetch();
    }

    public function login_api() {
        $data = input();
        $admin = Db::name('admin')->where('username',$data['username'])->find();
        if(!$admin) {
            $this->json(1,'账号不存在');
        } else if(md5($data['password']) != $admin['password']) {
            $this->json(2,'密码错误');
        }  else if ($admin['is_use'] == 0) {
            $this->json(3,'该账号被禁用');
        }



        session('admin_id',$admin['id']);
        session('username',$admin['username']);
        $this->json(0,'登录成功');
    }


    public function login() {
        return  $this->fetch();
    }


}
