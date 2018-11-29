<?php

/**
 * 后台公共文件
 */
namespace app\admin\controller;

use app\admin\controller\Basics;
class Category extends Basics
{
    public function add()
    {
        if($this->request->isAjax()) {
            $cate_name = input('cate_name');
            $cate_rake = input('cate_rake');
            $is_show = input('is_show');

            if(!$cate_name || !$cate_rake || !$is_show) {
                $this->json(1,'缺少参数');
            }


            $data = [
                'category_name' => $cate_name,
                'rake' => $cate_rake,
                'is_show' => $is_show,
                'add_time' => time()
            ];

            if(!Db('ls_category') -> insert($data)){
                $this->json(2,'添加失败');
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
    }

    public function get_edit()
    {
        if($this->request->isAjax()) {
           $id = input('id');

            $data =  Db('ls_category')->where('id='.$id)->find();

            if(!$data) {
                $this->json(2,'失败');
            } else {
                $this->json(0,'成功',$data);
            }
        }
    }

    public function index()
    {
        if($this->request->isAjax()) {
            $page = input('page') ? input('page'):1;
            $row = 1000;
            $limit = ($page-1)*$row.','.$row;

            $data =  Db('ls_category')->limit($limit)->order('rake desc')->select();

            if(!$data) {
                $this->json(2,'失败');
            } else {
                $this->json(0,'成功',$data);
            }
        }
        return  $this->fetch();
    }
}
