<?php
namespace Admin\Controller;

use Think\Controller;

class ArticleController extends CommonController
{
    public function lst()
    {
        $article = D('ArticleView');
        $count = $article->count();   // 查询满足要求的总记录数
        $Page = new \Think\Page($count,3); // 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show = $Page->show();  //分页显示输出
        $list = $article->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    public function add()
    {
        $article = D('Article');
        if (IS_POST) {
            $date['title'] = I('title');
            $date['desc'] = I('desc');
            $date['pic'] = I('pic');
            $date['cateid'] = I('cateid');
            $date['content'] = I('content');
            $date['time'] = time();
//            var_dump($_FILES['pic']['tmp_name']);exit;

            if($_FILES['pic']['tmp_name'] != ''){
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 3145728;  //设置附件上传大小
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); //设置附件上传类型
                $upload->rootPath = './'; //设置附件上传根目录
//                $upload->rootPath = './Public/Uploads/'; //设置附件上传根目录
                $upload->savePath = '/Public/Uploads/';//设置附件上传子目录
                //上传文件
                $info   =   $upload->uploadOne($_FILES['pic']);
                if(!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());exit;
                }else{// 上传成功 获取上传文件信息
                    $date['pic'] = $info['savepath'].$info['savename'];
                }
            }else{
                echo 'cuowu';exit;
            }

            if ($article->create($date)){
                if ($article->add()){
                    $this->success('添加栏目成功',U('lst'));
                }else{
                    $this->error('添加栏目失败!');
                }
            }else{
                $this->error($article->getError());
            }
            return;
        }
        $cate = D('cate');
        $cateres = $cate->select();
        $this->assign('cateres',$cateres);
        $this->display();
    }

    public function edit()
    {
        $article = D('article');
        if (IS_POST) {
            $date['id'] = I('id');
            $date['title'] = I('title');
            $date['desc'] = I('desc');
            $date['pic'] = I('pic2');
            $date['cateid'] = I('cateid');
            $date['content'] = I('content');
//            var_dump($_FILES['pic']['tmp_name']);exit;

            if($_FILES['pic']['tmp_name'] != ''){
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 3145728;  //设置附件上传大小
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg'); //设置附件上传类型
                $upload->rootPath = './'; //设置附件上传根目录
//                $upload->rootPath = './Public/Uploads/'; //设置附件上传根目录
                $upload->savePath = '/Public/Uploads/';//设置附件上传子目录
                //上传文件
                $info   =   $upload->uploadOne($_FILES['pic']);
                if(!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());exit;
                }else{// 上传成功 获取上传文件信息
                    $date['pic'] = $info['savepath'].$info['savename'];
                }
            }

            if ($article->create($date)){
                if ($article->save() !== false){   //返回影响行数，需用全等来判断是否成功
                    $this->success('修改文章成功',U('lst'));
                }else{
                    $this->error('修改文章失败!');
                }
            }else{
                $this->error($article->getError());
            }
            return;
        }
        $articler = $article->find(I('id'));
        $this->assign('articler',$articler);
        $cateres = D('Cate')->select();
        $this->assign('cateres',$cateres);
        $this->display();
    }

    public function del()
    {
        $article = D('article');
        if($article->delete(I('id'))){
            $this->success('删除栏目成功',U('lst'));
        }else{
            $this->error('删除栏目失败！');
        }
    }

    public function sort(){
        $article = D('article');
        foreach($_POST as $id=>$sort){
            $article->where(array('id'=>$id))->setField('sort',$sort);
        }
        $this->success('排序成功',U('lst'));
    }

}