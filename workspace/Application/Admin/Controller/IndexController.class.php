<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
         if(session('adminuser')){
            $this->display();
        }
       else   redirect('/admin.php?c=Login');
    }
   
}