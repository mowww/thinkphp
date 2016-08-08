<?php
namespace Admin\Controller;
use Think\Controller;
class MenuController extends CommonController {
    public function index(){
       $this->display();
    }
   public function add(){
        if(IS_POST){
            //参数不存在，或参数为空
            if(!isset($_POST['name']) || !$_POST['name']){
                return json_show(0,"菜单名不能为空");
            }
             if(!isset($_POST['m']) || !$_POST['m']){
                return json_show(0,"模块名不能为空");
            }
             if(!isset($_POST['c']) || !$_POST['c']){
                return json_show(0,"控制器名不能为空");
            }
             if(!isset($_POST['f']) || !$_POST['f']){
                return json_show(0,"方法名不能为空");
            }


        }else{
            $this->display();
        }
        
   }
}