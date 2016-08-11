<?php
/**
 * 图片相关
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;

/**
 * 文章内容管理
 */
class ImageController extends CommonController {
    private $_uploadObj;
    public function __construct() {

    }
    public function ajaxUploadImage() {   
        $upload = D("UploadImage");
        $res = $upload->imageUpload();
        if($res===false) {
            return json_show(0,'上传失败','');
        }else{
            return json_show(1,'上传成功',$res);
        }

    }
    /**
     * POST参数:　imgFile: 文件名称
     * @return [type] [description]
     */
    public function kindUpload() {   
        $upload = D("UploadImage");
        $res = $upload->upload();
        if($res===false) {
            return kind_show(1,'上传失败');
        }
        
        return kind_show(0,$res);
       

    }
   

}