<?php
namespace Home\Controller;
use Think\Controller;
class ArticleController extends CommonController {
    public function index(){
        $arts=  D('article')->find(I('id'));
        $this->assign('arts',$arts);
        $this->cate($arts['cateid']);
        $this->display();
    }

    public function cate($cateid){
        $cate = D('cate')->find($cateid);
        $this->assign('catename',$cate['catename']);
    }

}