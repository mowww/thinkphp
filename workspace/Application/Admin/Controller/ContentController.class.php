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
            $listcount = D('News')->getNewsCount($data);
            //实例化分页对象
            $res = new \Think\Page($listcount,$pagesize);
            $pageres = $res->show();
            $this->assign('pageRes',$pageres);
            $this->assign('list',$list);
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
}