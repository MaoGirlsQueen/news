<?php


namespace app\api\controller\v1;


use app\api\controller\Common;
use app\common\lib\Alidayu;

class Identify extends Common
{

    /**
    设置短信验证码 post
     **/
     public function save(){
         if(!request()->isPost()){
             show(0,'提交的数据不合法',[],403);
         }

         //校验数据

         $validate  = validate('Identify');
         if(!$validate->check(input('post.'))){
             return show(0,$validate->getError(),[],403);
         }
         $id = input('param.id');
         if(Alidayu::getInstance()->setSmsIdentify()){
             return show(1,'ok',[],201);
         }else{
             return show(0,'error',[],403);
         }
     }
}