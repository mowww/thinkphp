<?php
/**
 * @Author: wuweiwei
 * @Date:   2016-08-08 09:38:24
 * @Last Modified by:   wuweiwei
 * @Last Modified time: 2016-08-08 11:21:54
 */
    function json_show($status,$message,$data=array()){
        $ret =array(
                   'status'  => $status,
                   'message' => $message,
                   'data'    =>  $data,
            );
        exit( json_encode($ret));
    }