<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){

        if(session('adminuser')){
           redirect('/admin.php');
        }
        else $this->display();
    }
   public function check(){
       $username = $_POST['username'];
       $password = $_POST['password'];
        if(!trim($username)){
            return json_show(0,'用户名为空');
        }

        if(!trim($password)){
            return json_show(0,'密码为空！');
        }

       $ret = D('Admin')->getAdminByUsername($username);
        if(!$ret){
            
              return json_show(0,'用户不存在');
         }
        $password = D('Admin')->getMd5password($password);
       
        if($ret['password']!=$password){
             return json_show(0,'密码错误');
        }

        session('adminuser',$ret);

        return json_show(1,'登陆成功');
    }
   public function loginOut(){
         session('adminuser',null);
         redirect('/admin.php?c=login');
         return ;
   }
}