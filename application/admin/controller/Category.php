<?php

/**
 * 后台公共文件
 */
namespace app\admin\controller;

use app\admin\controller\Basics;
use think\Db;
class Category extends Basics
{


    public function add()
    {
        if($this->request->isAjax()) {
            if(!Db::name('category') ->data($this->request->post())->insert()){
               $this->json(1,'添加失败');
            } else {
                $this->json(0,'添加成功');
            }
        }
        return  $this->fetch();
    }

    public function edit()
    {
        if($this->request->isAjax()) {
            $cate_name = input('cate_name');
            $cate_rake = input('cate_rake');
            $is_show = input('is_show');
            $id = input('id');

            if(!$cate_name || !$cate_rake || !$is_show || !$id) {
                $this->json(1,'缺少参数');
            }


            $data = [
                'category_name' => $cate_name,
                'rake' => $cate_rake,
                'is_show' => $is_show,
                'add_time' => time()
            ];

            if(Db('ls_category') -> where('id='.$id)->update($data) == 0){
                $this->json(2,'修改失败');
            } else {
                $this->json(0,'修改成功');
            }
        }
        return  $this->fetch();
    }


    public function index()
    {
            $page = input('page') ? input('page'):1;
            $row = 1000;
            $limit = ($page-1)*$row.','.$row;
            $data =  Db::name('category')->limit($limit)->order('rake desc')->select();

            $this->assign('data',$data);
           return  $this->fetch();
    }
}
