<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
    public function index(){
        $admin = D('admin');
        if($_POST){
            if ($admin ->create($_POST,4)){
                if($admin->login()){
                    $this->success('登录成功',U('index/index'));
                }else{
                    $this->error('您的用户名或密码错误');
                }
            }else{
                $this->error($admin->getError());
            }
            return;
        }
        if($_SESSION['id']){
            $this->error('您已经登录',U('Index/index'));
        }else{
            $this->display('login');
        }

    }

    public function verify(){
        $Verify =     new \Think\Verify();
        $Verify->fontSize = 60;
        $Verify->length   = 4;
        $Verify->useNoise = false;
        $Verify->entry();
    }

}