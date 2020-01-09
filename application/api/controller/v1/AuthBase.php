<?php


namespace app\api\controller\v1;


use app\api\controller\Common;
use app\common\lib\Aes;
use app\common\lib\exception\ApiException;
use think\Request;

/****
  客户端auth 登录权限基础类库
 * 1、每个接口（都需要 个人中心 点赞评论）都要继承类库
 * 2、判断access_user_token 是否合法
 * 3、用户信息 -> user
 **/
class AuthBase extends Common
{
    public $user=[];

   public function __construct(Request $request = null)
   {
       parent::_initialize();
       $result = $this->isLogin();
       if(empty($result)){
           throw  new ApiException('您还没有登录',401);
       }
   }

   /**
   判断是否登陆
    **/
   public function isLogin(){
     if(empty($this->header['access_user_token'])){
         return false;
     }

     //对access_user_token 进行解密
       $accessUserToken = (new Aes())->decrypt($this->header['access_user_token']);

      if(empty($accessUserToken)){
          return false;
      }
      //判断有没有||
      if(!preg_match('||',$accessUserToken)){
          return false;
      }

      list($token,$id)=explode('||',$accessUserToken);
       $user = model('User')->get(['token'=>$token]);
       if(!$user || $user->status !=1){
           return true;
       }
       //  判断时间是否过期
       if(time() > $user->time_out){
           return false;
       }
       halt($user);
       $this->user = $user;
       return true;
   }
}