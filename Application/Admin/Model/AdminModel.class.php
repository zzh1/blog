<?php
namespace Admin\Model;

use Think\Model;

class AdminModel extends Model
{
    protected $_validate = array(
        array('username','require','管理人名称不能为空',1,'regex',3), // 在新增的时候验证name字段是否唯一
        array('username','','管理人名称不得重复！',1,'unique',3), // 在新增的时候验证name字段是否唯一
        array('password','require','管理人密码不能为空',1,'regex',3), // 在新增的时候验证name字段是否唯一
        array('username','require','登录管理人名称不能为空',1,'regex',4), // 在新增的时候验证name字段是否唯一
        array('password','require','登录管理人密码不能为空',1,'regex',4), // 在新增的时候验证name字段是否唯一
        array('verify','check_verify','验证码错误',1,'callback',4), // 在新增的时候验证name字段是否唯一
    );


    public function login(){
        $password = $this->password;
        $info = $this->where(['username'=>$this->username])->find();
        if($info){
            if($info['password'] == md5($password)){
                session('id',$info['id']);
                session('username',$info['username']);
                session('password',$info['password']);
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    // 检测输入的验证码是否正确，$code为用户输入的验证码字符串
    function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

}