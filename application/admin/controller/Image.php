<?php


namespace app\admin\controller;


use think\Request;

class Image extends Base
{

    /**
      后台图片上传逻辑
     **/
   public function upload(){
       $file = Request::instance()->file('file');
       $info = $file->move('upload');
       if($info && $info->getPathname()){
            $data=[
                'status'=>1,
                'message'=>'OK',
                'data'=>'/'.$info->getPathname()
            ];
           echo json_encode($data);exit;
       }
       echo json_encode([
           'status'=>0,
           'message'=>'error',
           'data'=>[]
       ]);
   }
}