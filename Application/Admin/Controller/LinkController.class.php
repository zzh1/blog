<?php
namespace Admin\Controller;

use Think\Controller;

class LinkController extends CommonController
{
    public function lst()
    {
        $link = D('link');
        $count = $link->count();   // 查询满足要求的总记录数
        $Page = new \Think\Page($count,3); // 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();  //分页显示输出
        $list = $link->order('sort desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    public function add()
    {
        $link = D('link');
        if (IS_POST) {
            $date['title'] = I('title');
            $date['url'] = I('url');
            $date['desc'] = I('desc');
            if ($link->create($date)){
                if ($link->add()){
                    $this->success('添加栏目成功',U('lst'));
                }else{
                    $this->error('添加栏目失败!');
                }
            }else{
                $this->error($link->getError());
            }
            return;
        }
        $this->display();
    }

    public function edit()
    {
        $link = D('link');
        if(IS_POST){
            $data['id'] = I('id');
            $data['title'] = I('title');
            $data['url'] = I('url');
            $data['desc'] = I('desc');
            if($link -> create($data)){
                if($link->save()){
                    $this->success('修改链接成功！',U('lst'));
                }else{
                    $this->error('修改链接失败！');
                }
            }else{
                $this->error($link->getError());
            }
            return;
        }
        $linkr = $link->find(I('id'));
        $this->assign('linkr',$linkr);
        $this->display();
    }

    public function del()
    {
        $link = D('link');
        if($link->delete(I('id'))){
            $this->success('删除栏目成功',U('lst'));
        }else{
            $this->error('删除栏目失败！');
        }
    }

    public function sort(){
        $link = D('link');
        foreach($_POST as $id=>$sort){
            $link->where(array('id'=>$id))->setField('sort',$sort);
        }
        $this->success('排序成功',U('lst'));
    }

}