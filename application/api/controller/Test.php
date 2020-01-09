<?php


namespace app\api\controller;

use ali\top\request\AlibabaAliqinFcSmsNumSendRequest;
use ali\top\TopClient;
use app\common\lib\exception\ApiException;
use app\common\lib\IAuth;
use think\Controller;

class Test extends Common
{
   public function index(){
       $str = IAuth::setAppLoginToken();
       halt($str);
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
       return  show(config('code.app_show_success'),"ok",input('post.'),200);
   }
   /****
   发送验证码
    */
   public function send(){
       $c = new TopClient();
       $c->appkey = 'LTAI4Fr2xCKSz2shYncbkPju';
       $c->secretKey= 'xy3XQksFmVPtG1CA65BtnIV7MajMgZ';
       $req= new AlibabaAliqinFcSmsNumSendRequest();
       $req->setExtend('123456');
       $req->setSmsType('normal');
       $req->setSmsFreeSignName('喵尚站');
       $req->setSmsParam("{\"number\":\"3456\"}");
       $req->getRecNum('17512427463');
       $req->setSmsTemplateCode('SMS_182375123');
       $resp= $c->execute($req);

   }
}