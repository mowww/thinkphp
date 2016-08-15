<?php
namespace Common\Model;
use Think\Model;

/**
 * 推荐位wmodel操作
 * @author  singwa
 */
class PositionContentModel extends Model {
	private $_db = '';

	public function __construct() {
		$this->_db = M('position_content');
	}

	public function select($data = array(),$page,$pagesize=10) {

		if($data['title']) {
			$data['title'] = array('like', '%'.$data['title'].'%');
		}
		if(isset($data['position_id']) && $data['position_id']){
            $d['position_id'] = intval($data['position_id']);
        }
		  //起始位置 
        $offset  = ($page-1) * $pagesize;
		$list = $this->_db->where($data)->order('listorder asc ,news_id asc')->limit($offset,$pagesize)->select();
        return $list;
	}
    //获取数据总条数
    public function getCount($data=array()){
          $d = $data;
         // $d['status'] = array('neq',-1);
        //模糊搜索  标题名  栏目id
        if(isset($data['title']) && $data['title']){
            $d['title'] = array('like','%'.$data['title'].'%');
        }
        if(isset($data['position_id']) && $data['position_id']){
            $d['position_id'] = intval($data['position_id']);
        }
        return  $this->_db->where($d)->count();
    }
	public function find($id) {
		$data = $this->_db->where('id='.$id)->find();
		return $data;
	}
    /**
    * 插入相关数据
    * @param  array  $data [description]
    * @return intval
    */
    public function insert($res=array()) {
    	if(!$res || !is_array($res)) {
    		return 0;
    	}
    	if(!$res['create_time']) {
    		$res['create_time'] = time();
    	}
		
    	return $this->_db->add($res);
    }

	/**
	 * 通过id更新的状态
	 * @param $id
	 * @param $status
	 * @return bool
	 */
	public function updateStatusById($id, $status) {
		if(!is_numeric($status)) {
			throw_exception("status不能为非数字");
		}
		if(!$id || !is_numeric($id)) {
			throw_exception("ID不合法");
		}
		$data['status'] = $status;
		return  $this->_db->where('id='.$id)->save($data); // 根据条件更新记录

	}

	public function updateById($id, $data) {

		if(!$id || !is_numeric($id)) {
			throw_exception("ID不合法");
		}
		if(!$data || !is_array($data)) {
			throw_exception('更新的数据不合法');
		}
		return  $this->_db->where('id='.$id)->save($data); // 根据条件更新记录
	}

	/**7 排序**/
	public function updateListorderById($id, $listorder) {
        if(!$id || !is_numeric($id)) {
            throw_exception('ID不合法');
        }

        $data = array('listorder'=>intval($listorder));
        return $this->_db->where('id='.$id)->save($data);

    }
}
