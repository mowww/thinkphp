<?php
/**
 * @Author: wuweiwei
 * @Date:   2016-08-08 09:38:24
 * @Last Modified by:   wuweiwei
 * @Last Modified time: 2016-08-10 14:05:06
 */
    /**
     * 数据转换成json格式,用于返回到前台
     * @param  num $status  状态码
     * @param  string $message 说明
     * @param  array  $data    数据
     * @return array  json格式数据          
     */
    function json_show($status,$message='',$data=array()){
        $ret =array(
                   'status'  => $status,
                   'message' => $message,
                   'data'    =>  $data,
            );
        exit( json_encode($ret));
    }
    /**
     * 转换后台的类型数据,换成易读文字
     * @param  num $type 菜单标识
     * @return [type]       [description]
     */
    function getMenuType($type){
        return $type == 1 ? '后台菜单':'前段导航';
    }
    /**
     * 转换后台的状态数据,换成易读文字
     * @param  num $status 菜单标识 
     * @return [type]         [description]
     */
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
     /**
      * 设置菜单的url
      * @param  array $nav 菜单的信息，m,c,f等
      * @return string   url    
      */
     function getAdminMenuUrl($nav){
        $url = '/admin.php?c='.$nav['c'].'&a='.$nav['f'];
        if($nav['f']=='index'){
            $url = '/admin.php?c='.$nav['c'];
        }
        return $url;
    }
    /**
     * 设置后台导航栏当前菜单高亮
     * @param  string $navc 控制器名
     * @return [type]       [description]
     */
    function getActive($navc){
        $c = strtolower(CONTROLLER_NAME);
        if(strtolower($navc==$c)){
            return 'class="active"';
        }
        return '';
    }
