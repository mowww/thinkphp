<?php
/**
 * 后台Index相关
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class PositioncontentController extends CommonController {
    public function index(){
        $data = array();
         // 获取推荐位里面的内容
        $positions = D("Position")->getPositions();
        $data['status'] = array('neq', -1);
        //文章标题
        if($_GET['title']) {
            $data['title'] = trim($_GET['title']);
            //$this->assign('title', $data['title']);
        }
        //推荐位id
         if(isset($_GET['position_id']) && $_GET['position_id']){
                $data['position_id'] = intval($_GET['position_id']);
            }
        //分页操作
        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1 ;
        $pagesize = $_REQUEST['pagesize'] ? $_REQUEST['pagesize'] :5;  
        //获取内容
        $contents = D("PositionContent")->select($data,$page,$pagesize);
        $listcount = D('PositionContent')->getCount($data);
         //实例化分页对象
        $res = new \Think\Page($listcount,$pagesize);
        $pageres = $res->show();
        $this->assign('pageRes',$pageres);
        $this->assign('positions', $positions);
        $this->assign('contents', $contents);
       // $this->assign('positionId', $data['position_id']);
        $this->display();
    }

    public function add() {
        if($_POST) {
            if(!isset($_POST['position_id']) || !$_POST['position_id']) {
                return show(0, '推荐位ID不能为空');
            }
            if(!isset($_POST['title']) || !$_POST['title']) {
                return show(0, '推荐位标题不能为空');
            }
            if(!$_POST['url'] && !$_POST['news_id']) {
                return show(0, 'url和news_id不能同时为空');
            }
            if(!isset($_POST['thumb']) || !$_POST['thumb']) {
                if($_POST['news_id']) {
                    $res = D("News")->find($_POST['news_id']);
                    if($res && is_array($res)) {
                        $_POST['thumb'] = $res['thumb'];
                    }
                }else{
                    return json_show(0,'图片不能为空');
                }

            }
            if($_POST['id']) {
              return $this->save($_POST);
            }
            try{
                $id = D("PositionContent")->insert($_POST);
                if($id) {
                    return json_show(1, '新增成功');
                }
                return json_show(0, '新增失败');
            }catch(Exception $e) {
                return json_show(0, $e->getMessage());
            }
        }else {
            $positions = D("Position")->getPositions();
            $this->assign('positions', $positions);
            $this->display();
        }
    }

    public function edit() {

        $id = $_GET['id'];
        $position = D("PositionContent")->find($id);
        $positions = D("Position")->getPositions();
        $this->assign('positions', $positions);
        $this->assign('vo', $position);
        $this->display();
    }

    public function save($data) {
        $id = $data['id'];
        unset($data['id']);

        try {
            $resId = D("PositionContent")->updateById($id, $data);
            if($resId === false) {
                return json_show(0, '更新失败');
            }
            return json_show(1, '更新成功');
        }catch(Exception $e) {
            return json_show(0, $e->getMessage());
        }
    }

    public function setStatus() {
         if($_POST){
            $id = intval($_POST['id']);
            $status = intval($_POST['status']);
        //执行数据更新操作
        try{
                 $sid = D('PositionContent')->updateStatusById($id,$status);
                 if($sid==false){
                    return json_show(0,"id异常，修改失败！");
                }
                 else {
                    return json_show(1,"修改成功！");
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
            //dump($_POST);exit;
            $listorder = $_POST['listorder'];
            foreach ($listorder as $newid => $value) {
               try{
                    $id = D('PositionContent')->updateListorderById($newid,$value);
                    if($id===false){
                        $error[]=$newid;
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