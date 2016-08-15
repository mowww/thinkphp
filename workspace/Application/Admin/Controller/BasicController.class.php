<?php
namespace Admin\Controller;
use Think\Controller;
class BasicController extends CommonController{
    public function index(){
        $data =  D('Basic')->select();
        $this->assign('data',$data);
       $this->display();
    }
    public function add(){
        if($_POST){
            if(!$_POST['title']){
                return json_show(0,'标题不能为空！');
            }
            if(!$_POST['keywords']){
                return json_show(0,'站点关键词不能为空！');
            }
            if(!$_POST['description']){
                return json_show(0,'站点描述不能为空！');
            }
            try{
                 $data = array(
                        'title' => $_POST['title'],
                        'keywords' => $_POST['keywords'],
                        'description' => $_POST['description'],
                    );
                  D('Basic')->save($data);
                  return json_show(1,'保存配置成功!');
            }catch(Execption $e){
                     return json_show(0,$e->message());
            }
             
        }else json_show(0,'保存配置失败!没有数据');
    }
  
}