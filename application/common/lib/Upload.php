<?php


namespace app\common\lib;
vendor('Qiniu.autoload');
//引入鉴权类
use Qiniu\Auth;
//引入上传类
use Qiniu\Storage\UploadManager;
/**
 图片上传基类
 */
class Upload
{
     public static function image(){

         if(empty($_FILES['file']['tmp_name'])){
             exception('上传图片不合法',404);
         }
         //上传的文件路径
         $filePath = $_FILES['file']['tmp_name'];
         //获取后缀名方法一
         /**$ext = explode('.',$_FILES['file']['name']);
         $ext = $ext[1];**/
         //获取后缀名方法二

         $pathinfo = pathinfo($_FILES['file']['name']);
         $ext = $pathinfo['extension'];
         //上传需要的配置文件
         $config = config('qiniu');

         //构建一个鉴权对象
         $auth = new Auth($config['ak'],$config['sk']);

         //生成上传的token
         $token = $auth->uploadToken($config['bucket']);
         //上传到七牛的文件名
         $key = date('Y').'/'.date('m').'/'.substr(md5($filePath),0,5).date('YmdHis').rand(0,9999).'.'.$ext;
         //上传文件
         $uploadMgr = new UploadManager();
         list($res,$err) = $uploadMgr->putFile($token,$key,$filePath);

         if($err !== null){
             return null;
         }else{
             return $key;
         }
     }
}