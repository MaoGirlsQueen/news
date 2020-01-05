<?php


namespace app\api\controller;

use app\common\lib\exception\ApiException;
use think\Controller;

class Test extends Common
{
   public function index(){
       echo "1";
   }
   public function update(){
       $data = input('put.');
       halt($data);
   }
   public function save(){
       $data = input('post.');
       if($data['gg'] != 1){
       throw new ApiException('提交的参数不合法o',403);
       }
       return  show(1,"ok",input('post.'),200);
   }
}