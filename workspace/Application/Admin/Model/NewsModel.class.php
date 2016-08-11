<?php
namespace Admin\Model;
use Think\Model;

/**
 * 文章内容model操作
 * @author  wuweiwei
 */
class NewsModel extends Model {
    private $_db = '';

    public function __construct() {
        $this->_db = M('news');
    }
    public function insert($data = array()){
       if($data==null || !is_array($data)){
            return 0;
       } 
       $data['username'] =  getLoginUserName();
       return $this->_db->add($data);
    }
    public function getNews($data,$page,$pagesize=10){
        
        $d = $data;
        //模糊搜索  标题名  栏目id
        if(isset($data['title']) && $data['title']){
            $d['title'] = array('like','%'.$data['title'].'%');
        }
        if(isset($data['catid']) && $data['catid']){
            $d['catid'] = intval($data['catid']);
        }
       //起始位置 
        $offset  = ($page-1) * $pagesize;
       //获取数据  
        $list = $this->_db->where($d)->order('listorder asc ,news_id asc')->limit($offset,$pagesize)->select();
        return $list;
    }
    //获取数据总条数
    public function getNewsCount($data=array()){
          $d = $data;
        //模糊搜索  标题名  栏目id
        if(isset($data['title']) && $data['title']){
            $d['title'] = array('like','%'.$data['title'].'%');
        }
        if(isset($data['catid']) && $data['catid']){
            $d['catid'] = intval($data['catid']);
        }
        return  $this->_db->where($data)->count();
    }
}
