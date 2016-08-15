<?php
namespace Common\Model;
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
     public function select($data = array(), $limit = 100) {

        $conditions = $data;
        $list = $this->_db->where($conditions)->order('news_id desc')->limit($limit)->select();
        return $list;
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
          $d['status'] = array('neq',-1);
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
          $d['status'] = array('neq',-1);
        //模糊搜索  标题名  栏目id
        if(isset($data['title']) && $data['title']){
            $d['title'] = array('like','%'.$data['title'].'%');
        }
        if(isset($data['catid']) && $data['catid']){
            $d['catid'] = intval($data['catid']);
        }
        return  $this->_db->where($d)->count();
    }
    //查找要更改的数据
    public function find($id){
        if($id==null || !is_numeric($id)){
             return array();
        }
        $data['news_id'] = $id;
        return $this->_db->where($data)->find();
    }
    public function updateNewsById($id,$data){
        if($id==null || !is_numeric($id)){
            throw_exception("id不合法");
        }
        if($data==null || !is_array($data)){
            throw_exception("更新数据不合法");
        }
        $map['news_id'] = $id;
        return $this->_db->where($map)->save($data);
    }
    public function updateStatusById($id,$status){
        //判断id
        if($id==null || !is_numeric($id)){
            throw_exception("id不合法");
        }
        if($status==null || !is_numeric($status)){
            throw_exception("状态不合法");
        }
        $map['news_id'] = $id;
        $data['status'] = $status;
        return $this->_db->where($map)->save($data);
    }
     public function updateNewListorderById($id,$listorder){
        //判断id
        if($id==null || !is_numeric($id)){
            throw_exception("id不合法");
        }
        if( $listorder==null || !is_numeric($listorder)){
            throw_exception("数据不合法".$listorder);
        }
        $map['news_id'] = $id;
        $data['listorder'] = $listorder;
        return $this->_db->where($map)->save($data);
    }
     public function getNewsByIdArray($idin){
        if(!$idin || !is_array($idin)){
           throw_exception("参数不合法");
         }
         $data = array(
            'news_id' => array('in',implode(',',$idin)),
         );
         return $this->_db->where($data)->select();
    }
    /**
     * 获取排行的数据
     * @param array $data
     * @param int $limit
     * @return array
     */
    public function getRank($data = array(), $limit = 100) {
        $list = $this->_db->where($data)->order('count desc,news_id desc ')->limit($limit)->select();
        return $list;
    }

    public function updateCount($id, $count) {
        if(!$id || !is_numeric($id)) {
            throw_exception("ID 不合法");

        }
        if(!is_numeric($count)) {
            throw_exception("count不能为非数字");
        }

        $data['count'] = $count;
        return $this->_db->where('news_id='.$id)->save($data);

    }

    public function maxcount() {
        $data = array(
            'status' => 1,
        );
        return $this->_db->where($data)->order('count desc')->limit(1)->find();
    }

}
