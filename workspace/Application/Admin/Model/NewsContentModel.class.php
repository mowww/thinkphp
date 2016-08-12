<?php
namespace Admin\Model;
use Think\Model;

/**
 * 文章内容content model操作
 * @author  wuweiwei
 */
class NewsContentModel extends Model {
    private $_db = '';

    public function __construct() {
        $this->_db = M('news_content');
    }
    public function insert($data = array()){
       if($data==null || !is_array($data)){
            return 0;
       } 
       if(isset($data['content']) && $data['content']){
            //转化
            $data['content'] = htmlspecialchars($data['content']);
       } 
       return $this->_db->add($data);
   }
   //查找要更改的数据
    public function find($id){
        if($id==null || !is_numeric($id)){
             return array();
        }
        $data['news_id'] = $id;
        return $this->_db->where($data)->field('content')->find();
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
}
