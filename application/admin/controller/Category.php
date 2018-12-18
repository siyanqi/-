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
            if(!Db::name('category')->data($this->request->post())->insert()){
               $this->json(1,'添加失败');
            } else {
                $this->json(0,'添加成功');
            }
        }
        return  $this->fetch('Category/add');
    }

    public function edit()
    {
        $id = $this->request->param('id');

        if($this->request->isAjax()){
            if(!Db::name('category')->data($this->request->post())->update()){
                $this->json(1,'编辑失败');
            } else {
                $this->json(0,'编辑成功');
            }
        }

        $data = Db::name('category')->where('id',$id)->find();
        $this->assign('data',$data);

        return  $this->fetch('Category/edit');
    }

    public function del() {
        if($this->request->isAjax()) {
            $data = $this->request->param();
            $result = Db::name('category')->delete($data['id']);

            if (!$result) {
                $this->json(1, '删除失败');
            } else {
                $this->json(0, '删除成功');
            }
        }


    }


    public function index()
    {
            $page = input('page') ? input('page'):1;
            $row = 10;
            $limit = ($page-1)*$row.','.$row;
            $data =  Db::name('category')->limit($limit)->order('rake desc')->paginate($row);
            $page = $data->render();

            $count = Db::name('category')->count();

            $this->assign('data',$data);
            $this->assign('page',$page);
            $this->assign('count',$count);
            return  $this->fetch('Category/index');
    }
}
