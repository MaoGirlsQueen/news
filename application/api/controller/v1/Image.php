<?php


namespace app\api\controller\v1;


use app\common\lib\Upload;

class Image extends AuthBase
{
   public function save(){
      // print_r($_FILES);
       $image = Upload::image();
       if($image){
           return show(1,'ok',config('qiniu.image_url').'/'.$image,200);
       }
   }
}