<?php


namespace app\common\lib;

use ali\top\request\AlibabaAliqinFcSmsNumSendRequest;
use ali\top\TopClient;
use think\Cache;
use think\Exception;
use think\Log;

/***
* 阿里大于发送短信基础类库
 **/
class Alidayu
{
    const LOG_TPL = 'aliyun';
    /**
    静态变量保存全局的实例
 **/
   private static $_instance = null;
   /*****
   私有的构造方法
    **/
  private function __construct()
  {
  }

  /***
     静态方法 单例模式的唯一入口
   **/

  public static function getInstance(){
      if(is_null(self::$_instance)){
          self::$_instance = new self();
      }
      return self::$_instance;
  }

  /***
  设置短信验证
   */
  public function setSmsIdentify($phone = 0){

      //生成验证码随机数
      $code = rand(1000,9999);
      try{
          $c = new TopClient();
          $c->appkey = config('aliyun.appkey');
          $c->secretKey= config('aliyun.secretKey');
          $req= new AlibabaAliqinFcSmsNumSendRequest();
          $req->setExtend('123456');
          $req->setSmsType('normal');
          $req->setSmsFreeSignName(config('aliyun.signName'));
          $req->setSmsParam("{\"number\":\"".$code."\"}");
          $req->getRecNum($phone);
          $req->setSmsTemplateCode(config('aliyun.templateCode'));
          $resp= $c->execute($req);
      }catch (Exception $e){
          //记录日志
          Log::write(LOG_TPL.'code error'.$e->getMessage());
          return false;
      }

      if($resp->result->success == "true"){
          //设置验证码失效时间
          Cache::set($phone,$code,config('aliyun.identify_time'));
          return true;
      }
      Log::write(LOG_TPL.'code back'.json_encode($resp));
      return false;
  }

  /***
     根据手机号码查询验证码是否正常
   **/
  public function checkSmsIndetify($phone=0){
      if(!$phone){
          return false;
      }
      return Cache::get($phone);
  }
}