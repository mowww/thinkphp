<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model{
    private $_db='';
    public function __construct(){
        $this->_db = M('admin');
    }
    public function getAdminByUsername($username){
        $map['username'] = $username;
        return  $this->_db->where($map)->find();   
    }
    public function getMD5password($password){
        return MD5($password.C('MD5_PRE'));
    }
}