<?php
/**
 * @Author: wuweiwei
 * @Date:   2016-08-08 09:38:24
 * @Last Modified by:   wuweiwei
 * @Last Modified time: 2016-08-11 17:22:34
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

   //kindeditor 数据返回（封装kindeditor的格式）
    function kind_show($status,$data){
        header('Content-type:application/json;charset:utf-8');
        if($status==0){
            exit(json_encode(array('error'=>0,'url'=>$data)));
        }
         exit(json_encode(array('error'=>1,'message'=>$data)));
     } 
     /**
      *  获取登录用户的用户名
      * @return [type] [description]
      */
    function getLoginUserName(){
        return $_SESSION['adminuser']['username'] ? $_SESSION['adminuser']['username']:'';
    } 

    /**
      *  转换后台的菜单名数据,换成易读文字
      * @return [type] [description]
      */
    function getCatName($navs,$id){
        foreach($navs as $nav){
            if($nav['menu_id']==$id)
            return $nav['name'];
        }
    }
    /**
      *  转换后台的来源数据,换成易读文字
      * @return [type] [description]
      */
    function getCopyFromById($id){
        $copy = C('COPY_FROM');
        return $copy[$id] ? $copy[$id] : '';
    }
    /**
      *  转换后台的状态数据,换成易读文字
      * @return [type] [description]
      */
    function getNewStatus($status){
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
      *  判断是否有封面,换成易读文字
      * @return [type] [description]
      */
    function isThumb($thumb){
         if($thumb){
            return '<span style="color:red">有</span>' ;      
        }
           
            return '无';
    }