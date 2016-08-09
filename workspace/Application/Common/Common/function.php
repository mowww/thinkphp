<?php
/**
 * @Author: wuweiwei
 * @Date:   2016-08-08 09:38:24
 * @Last Modified by:   wuweiwei
 * @Last Modified time: 2016-08-09 11:30:40
 */
    function json_show($status,$message='',$data=array()){
        $ret =array(
                   'status'  => $status,
                   'message' => $message,
                   'data'    =>  $data,
            );
        exit( json_encode($ret));
    }
    function getMenuType($type){
        return $type == 1 ? '后台菜单':'前段导航';
    }
    function getMenuStatus($status){
        if($status==0){
            $str ="关闭";
        }
        if($status==1){
            $str="正常";
        }
        if($status==-1){
            $str="删除";
        }
        return $str;
     }
