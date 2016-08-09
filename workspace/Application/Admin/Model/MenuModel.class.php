<?php
namespace Admin\Model;
use Think\Model;

class MenuModel extends Model{
    private $_db='';
    public function __construct(){
        $this->_db = M('menu');
    }
    public function insert($data = array()){
       if(!$data || !is_array($data)){
            return 0;
       }  
       return $this->_db->add($data);
    }
    public function getMenu($data,$page,$pagesize=10){
        //获取不是删除status=-1的数据 
        $data['status'] = array('neq',-1);
       //起始位置 
        $offset  = ($page-1)*$pagesize;
       //获取数据  
        $list = $this->_db->where($data)->order('menu_id desc')->limit($offset,$pagesize)->select();
        return $list;
    }
    //获取数据总条数
    public function getMenuCount($data=array()){
        $data['status'] = array('neq',-1);
        return  $this->_db->where($data)->count();
    }
    //查找要更改的数据
    public function find($id){
        if(!$id || !is_numeric($id)){
             return array();
        }
        $data['menu_id'] = $id;
        return $this->_db->where($data)->find();
    }
    //更新保存修改后的信息
    public function updateMenuById($id,$data){
        if(!$id || !is_numeric($id)){
            throw_exception("id不合法");
        }
        if(!$data || !is_array($data)){
            throw_exception("更新数据不合法");
        }
        $map['menu_id'] = $id;
        return $this->_db->where($map)->save($data);
    }
    
}