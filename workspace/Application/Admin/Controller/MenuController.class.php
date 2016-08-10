<?php
namespace Admin\Controller;
use Think\Controller;
class MenuController extends CommonController {
    public function index(){
            //分页操作
            $data =array();
            //按条件搜索，前后台根据type参数，搜索
            if(isset($_REQUEST['type']) && in_array($_REQUEST['type'],array(0,1))){
                  $data['type'] = intval($_REQUEST['type']);
                  $this->assign('type',$data['type']);
            }else{
                $this->assign('type',3);
            }

            $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1 ;
            $pagesize = $_REQUEST['pagesize'] ? $_REQUEST['pagesize'] :3;
            $menus = D('Menu')->getMenu($data,$page,$pagesize);
            $menuscount = D('Menu')->getMenuCount($data);
            //实例化分页对象
            $res = new \Think\Page($menuscount,$pagesize);
            $pageres = $res->show();
            $this->assign('pageRes',$pageres);
            $this->assign('menu',$menus);
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
            //有menu_id这个参数，修改操作。
            if($_POST['menu_id']){
                        return $this->save($_POST);
            }
            $menus = D('Menu')->insert($_POST);
            if($menus==0){
                return json_show(0,'添加失败！');
            }else{
                return json_show(1,'添加成功!');
            }

        }else{
            $this->display();
        }
        
   }
     //获取数据的逻辑
    public function edit(){
            $menuid = $_GET['id'];
            $menu = D('Menu')->find($menuid);
            $this->assign('menu',$menu);
            $this->display();
    }
    public function save($data){
        $menuid = $data['menu_id'];
        unset($data['menu_id']);
        try{
             $id = D('Menu')->updateMenuById($menuid,$data);
             if($id==false){
                return json_show(0,"id异常，修改失败！");
            }
             else {
                return json_show(1,"修改成功！");
             }
        }catch(Exception $e){
            return json_show(0,$e->getmessage());
        }
    }
    public function setStatus(){
        if($_POST){
            $id = $_POST['id'];
            $status = $_POST['status'];
        //执行数据更新操作
        try{
                 $id = D('Menu')->updateStatusById($id,$status);
                 if($id==false){
                    return json_show(0,"id异常，删除失败！");
                }
                 else {
                    return json_show(1,"删除成功！");
                 }
            }catch(Exception $e){
                return json_show(0,$e->getmessage());
            }
        } 
         return json_show(0,"没有提交数据");
    }
    public function listorder(){
        $errors= array();
        if($_POST['listorder']){
            $listorder = $_POST['listorder'];
            foreach ($listorder as $menuid => $value) {
               try{
                    $id = D('Menu')->updateMenuListorderById($menuid,$value);
                    if($id===false){
                        $error[]=$menuid;
                    }
               }catch(Exception $e){
                     return json_show(0,$e->getmessage());
               }
            }        
            if($error){
                return json_show(0,'排序失败-'.implode(',',$errors));
            }
            return json_show(1,'排序数据成功');
        }
        return json_show(0,'排序数据异常');
    }
}