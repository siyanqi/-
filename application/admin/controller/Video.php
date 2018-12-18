<?php

/**
 * 后台公共文件
 */
namespace app\admin\controller;

use app\admin\controller\Basics;
use think\Db;


class Video extends Basics
{
    public function index()
    {
        $where = array();

        if(input('video_title')) {
            $where['video_title'] = input('video_title');
        }
        if(input('category_id')) {
            $id = Db::name('video_category')->field('video_id')->where('category_id',input('category_id'))->select();
            if($id) {
                $where['id'] = array('in',implode(',',array_column($id,'video_id')));
            }
        }

        $page = input('page') ? input('page'):1;

        $row = 10;
        $limit = ($page-1)*$row.','.$row;

        $data = Db::name('video')->where($where)->limit($limit)->order('rake desc')->paginate($row);
        $page = $data->render();
        $data = $data->all();
        foreach ($data as $k => $v) {
            $category_name = Db::name('video_category')->alias('a')->field('b.category_name')->where('a.video_id',$v['id'])->join('category b','a.category_id = b.id')->select();
            if($category_name) {
                $name = array_column($category_name,'category_name');
                $data[$k]['category_name'] = implode(',',$name);
            } else {
                $data[$k]['category_name'] = '';
            }

            $data[$k]['video_img'] = config('public.img').'/'.$v['video_img'];
            $data[$k]['video'] = config('public.video').'/'.$v['video'];
            $data[$k]['add_time'] = date('Y-m-d H:i',$v['add_time']);
        }
        $count = Db::name('video')->count();

        $category = Db::name('category')->select();

        $this->assign(array(
            'category' => $category,
            'data'     => $data,
            'page'     => $page,
            'count'     => $count,
        ));

        return  $this->fetch();
    }

    public function add()
    {
        if($this->request->isAjax()) {
            $data = input();
            $category = input('category_id/a');
            if(!$category) {
                $this->json(1,'分类不能为空');
            }

            $video_data = $this->data($data);

            if(!$id['id'] = Db::name('video')->insertGetId($video_data)) {
                $this->json(2,'添加失败');
            }
                foreach ($category as $v) {
                    $category = array(
                        'video_id' => $id['id'],
                        'category_id' => $v
                    );
                    Db::name('video_category')->data($category)->insert();
                }


            $this->json(0,'添加成功');

        }
        $category = Db::name('category')->select();
        $this->assign('category',$category);
        return  $this->fetch();
    }

    public function edit() {
        $id['id'] = input('id');

        if($this->request->isAjax()) {
            $data = input();
            $category = input('category_id/a');
            if(!$category) {
                $this->json(1,'分类不能为空');
            }

            $video_data = $this->data($data);

            if(!Db::name('video')->where('id',$id['id'])->update($video_data)) {
                $this->json(2,'修改失败');
            }

            Db::name('video_category')->where('video_id',$id['id'])->delete();

            foreach ($category as $v) {
                $category = array(
                    'video_id' => $id['id'],
                    'category_id' => $v
                );
                Db::name('video_category')->data($category)->insert();
            }

            $this->json(0,'修好成功');

        }

        $data = Db::name('video')->find($id['id']);
        $video_category = Db::name('video_category')->where('video_id',$id['id'])->select();
        $category = Db::name('category')->select();

        foreach ($category as $k => $v) {
              $category[$k]['type'] = 0;
            foreach ($video_category as $k1 => $v1) {
                if($v['id'] === $v1['category_id']) {
                    $category[$k]['type'] = 1;
                    break;
                } else {
                    $category[$k]['type'] = 0;
                }
            }
        }

        $data['video1_img'] = config('public.img').'/'.$data['video_img'];
        $data['video1'] = config('public.video').'/'.$data['video'];

        $this->assign('category',$category);
        $this->assign('data',$data);
        $this->assign('video_category',$video_category);
        return $this->fetch();
    }

    public function del(){
        $id = $this->request->param();
        if(count($id['id']) > 1) {
            $id['id'] = implode(',',$id['id']);
        }

        $data = Db::name('video')->where('id','in',$id['id'])->select();

        foreach ($data as $v) {
            @unlink(SITE_PATH.config('public.del_upload').'img/'.$v['video_img']);
            @unlink(SITE_PATH.config('public.del_upload').'video/'.$v['video']);
        }
        $c_res = Db::name('video_category')->where('video_id','in',$id['id'])->delete();
        $v_res = Db::name('video')->delete($id['id']);
        if(!$c_res && !$v_res) {
            $this->json(1,'删除失败');
        } else {
            $this->json(0,'删除成功');
        }
    }


    public function upload_img() {
        if(input('type') == 2) {
            $result = $this->upload(config('public.upload_img'),'img');

            $data = array(
                'path'=>$result['info'],
                'location'=>config('public.img').'/'
            );
        } else {
            $result = $this->upload(config('public.upload_video'),'video');

            $data = array(
                'path'=>$result['info'],
                'location'=>config('public.video').'/'
            );
        }

        if($result['type'] == 1) {
            $this->json(0,'上传成功',$data);
        } else {
            $this->json(1,'上传失败',$result['info']);
        }
    }

    public function del_upload() {
        $input = input();
        if($input['type'] == 1) {
            $path = SITE_PATH.config('public.del_upload').'img/'.$input['path'];
        } else {
            $path = SITE_PATH.config('public.del_upload').'video/'.$input['path'];
        }

        @unlink($path);
        $this->json(0,'删除成功');
    }


    public function data($data) {
        $video_data = array(
            'uid' => 0, // 0 为后台添加
            'video_title' => $data['video_title'],
            'rake'        => $data['rake'],
            'video_img'   => $data['video_img'],
            'video'       => $data['video'],
            'add_time'    => time(),
            'video_desc'  => $data['video_desc'],
            'is_show'     => $data['is_show'],
            'is_carousel' => $data['is_carousel']
        );
        return $video_data;
    }


}
