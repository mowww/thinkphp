<?php
namespace Common\Model;
use Think\Model;
class BasicModel extends Model{
    public function __construct() {

    }
    public function save($data){
        if(!$data){
            throw_exception('数据为空');
        }
        return  F('Basic_webconfig',$data);   
    }
    public function select(){
        return F('basic_webconfig');
    }
}