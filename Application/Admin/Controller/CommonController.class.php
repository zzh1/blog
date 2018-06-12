<?php
namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$_SESSION['id']){
            $this->error('您未登录,请先登录',U('Login/index'));
        }
    }
}