<?php
namespace Admin\Controller;
use Think\Controller;
class ContentController extends CommonController {
    public function index(){
            $data  = array();
             //模糊搜索  标题名  栏目id
            if(isset($_GET['title']) && $_GET['title']){
                $data['title'] = $_GET['title'];
            }
            if(isset($_GET['catid']) && $_GET['catid']){
                $data['catid'] = intval($_GET['catid']);
            }
           
             //分页操作
            $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1 ;
            $pagesize = $_REQUEST['pagesize'] ? $_REQUEST['pagesize'] :5;
            $list = D('News')->getNews($data,$page,$pagesize);
            $position = D("Position")->getPositions();
            $listcount = D('News')->getNewsCount($data);
            //实例化分页对象
            $res = new \Think\Page($listcount,$pagesize);
            $pageres = $res->show();
            $this->assign('pageRes',$pageres);
            $this->assign('list',$list);
            $this->assign('positions',$position);
             //前端导航数据
            $this->assign('website',D('Menu')->getBarMenus());
            $this->display();
           
    }
    public function add(){
        //插入数据
       if($_POST){
            if(!isset($_POST['title']) || !$_POST['title']){
                return json_show(0,'标题不存在');
            }
            if(!isset($_POST['small_title']) || !$_POST['small_title']){
                return json_show(0,'短标题不存在');
            }
            if(!isset($_POST['catid']) || !$_POST['catid']){
                return json_show(0,'文章栏目不存在');
            }
            if(!isset($_POST['keywords']) || !$_POST['keywords']){
                return json_show(0,'关键字不存在');
            }
            if(!isset($_POST['content']) || !$_POST['content']){
                return json_show(0,'content不存在');
            }
            //有news_id这个参数，修改操作。
            if($_POST['news_id']){
                        return $this->save($_POST);
            }
            $_POST['create_time'] = time();
            $newid = D('News')->insert($_POST);
            if($newid){
                $content['content'] = $_POST['content'];
                $content['news_id'] = $newid;
                $content['create_time'] = $_POST['create_time'];
                     $cid = D('NewsContent')->insert($content);
                     if($cid){

                        return json_show(1,'新增成功');
                     }else{
                        return json_show(1,'主表插入成功，副表插入成功');
                     }
            }else{
                    return json_show(0,'主表插入失败,新增失败');
                }
        }else{
            //获取栏目等信息
            $webMenu = D('Menu')->getBarMenus();
            $titleFontColor = C('TITLE_FONT_COLOR');
            $copyForm = C('COPY_FROM');
            $this->assign('webSiteMenu',$webMenu);
            $this->assign('titleFontColor',$titleFontColor);
            $this->assign('copyForm',$copyForm);
            $this->display();
        }
    }
    public function edit(){
            $newid = $_GET['id'];
            if(!$newid){
                $this->redirect('/admin.php?c=content');
            }
            $news = D('News')->find($newid);
            $news['content'] = D('NewsContent')->find($newid)['content'];
            $this->assign('news',$news);
            //获取栏目等信息
            $webMenu = D('Menu')->getBarMenus();
            $titleFontColor = C('TITLE_FONT_COLOR');
            $copyFrom = C('COPY_FROM');
            $this->assign('webSiteMenu',$webMenu);
            $this->assign('titleFontColor',$titleFontColor);
            $this->assign('copyFrom',$copyFrom);
            $this->display();
    
    }
    public function save($data){
        $news_id = $data['news_id'];
        $contentData['content'] = $data['content'];
        $data['update_time'] = time();
        $contentData['update_time'] = $data['update_time'];
        unset($data['news_id']);
        unset($data['content']);
        try{
             $id = D('News')->updateNewsById($news_id,$data);
             if($id==false){
                return json_show(0,"id异常，修改失败！");
            }
             else {
                $cid = D('NewsContent')->updateNewsById($news_id,$contentData);
                if($cid==false){
                    return json_show(0,"content修改失败！");
                }
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
                 $sid = D('News')->updateStatusById($id,$status);
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

            $listorder = $_POST['listorder'];
            foreach ($listorder as $newid => $value) {
               try{
                    $id = D('News')->updateNewListorderById($newid,$value);
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
    public function push(){
        $pid = intval($_POST['position_id']);
        $newsid = $_POST['push'];
        if($pid==null){
                return json_show(0,'没有选择推荐位'); 
        }
        if($newsid==null || !is_array($newsid)){
                return json_show(0,'请选择推荐的文章id进行推荐'); 
        }
        //所有推荐文章的详细内容
        try {
            $news = D("News")->getNewsByIdArray($newsid);
            if (!$news) {
                return json_show(0, '没有相关内容');
            }

            foreach ($news as $new) {
                $data = array(
                    'position_id' => $pid,
                    'title' => $new['title'],
                    'thumb' => $new['thumb'],
                    'news_id' => $new['news_id'],
                    'status' => 1,
                    'create_time' => $new['create_time'],
                );
                $position = D("PositionContent")->insert($data);
            }
        }catch(Exception $e) {
            return json_show(0, $e->getMessage());
        }

        return json_show(1, '推荐成功',array('jump_url'=>$jumpUrl));
    }
}