<?php
namespace Common\Model;
use Think\Model;

/**
 * 图片上传类
 */
class UploadImageModel extends Model {
    private $_uploadObj = '';
    private $_uploadImageData = '';

    const UPLOAD = 'upload';

    public function __construct() {
        $this->_uploadObj = new  \Think\Upload();
        //根路径
        $this->_uploadObj->rootPath = './'.self::UPLOAD.'/';
        //子目录生成方式  名
        $this->_uploadObj->subName = date(Y) . '/' . date(m) .'/' . date(d);
    }

    public function upload() {
        $res = $this->_uploadObj->upload();
        //POST参数:　imgFile: 文件名称
        if($res) {
            return '/' .self::UPLOAD . '/' . $res['imgFile']['savepath'] . $res['imgFile']['savename'];
        }else{
            return false;
        }
    }

    public function imageUpload() {
        //上传图片
        $res = $this->_uploadObj->upload();
        if($res) {
            //返回图片路径
            return '/' .self::UPLOAD . '/' . $res['file']['savepath'] . $res['file']['savename'];
        }else{
            return false;
        }
    }
}
