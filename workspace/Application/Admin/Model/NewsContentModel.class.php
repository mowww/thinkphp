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
}
