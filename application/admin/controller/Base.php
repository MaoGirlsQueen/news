<?php


namespace app\admin\controller;


use think\Controller;

class Base extends Controller
{
    //初始化
   public function _initialize()
   {
       // 判断用户是否登录
      $isLogin = $this->isLogin();
      if(!$isLogin){
          return $this->redirect('login/index');
      }
   }

   //判断是否登录
    public function isLogin(){
       //获取session
         $user = session(config('session.session_adminuser'),'',config('session.session_admin_scope'));
         if($user && $user->id){
             return true;
         }
        return false;
    }
}