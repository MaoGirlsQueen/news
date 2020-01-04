<?php


namespace app\admin\controller;
use app\common\lib\IAuth;

use think\Controller;
use think\Exception;

class Login extends Base
{

    public function _initialize(){}
   public function index(){
       //已经登录了 就跳转到首页
       $isLogin = $this->isLogin();
       if($isLogin){
           $this->redirect('index/index');
       }
       return $this->fetch();
   }
   //检测验证码
    /**
        登录相关业务
     **/
   public function check(){
       if(request()->isPost()){
           $data = input('post.');
           //获取验证码是不是正确的
           $code = captcha_check($data['code']);
           if(!$code){
               $this->error('验证码不正确');
           }
           $validate = validate('AdminUser');
           $result = $validate->check($data);
           if(!$result){
               $this->error($validate->getError());
           }
           // 判断用户是不是存在
           /**
           1.更新数据库，登录时间 ip
            *
            * 2、用户信息 保存到session中
            **/
           try {
               $user = model('AdminUser')->get(['username' => $data['username']]);
           }catch (Exception $e) {
               $this->error($e->getMessage());
           }
               if(!$user | $user->status !=config('code.status_normal')){
                   $this->error("用户不存在");
               }
               // 判断密码正不正确
               if( IAuth::setPassWord($data['password'])   != $user['password']){
                   $this->error("密码不正确");
               }
               $udata = [
                   'last_login_time'=>time(),
                   'last_login_ip'=>request()->ip()
               ];
               try{
               model('AdminUser')->save($udata,["id"=>$user->id]);
               }catch (Exception $e){
                   $this->error($e->getMessage());
               }
               // key  value  作用域
             session(config('session.session_adminuser'),$user,config('session.session_admin_scope'));

             $this->success('登录成功','index/index');

       }else{
           $this->error('请求不合法');
       }

   }

   /***
    * 退出登录
    * 1.清除session
    * 2.跳转到登录页面
   */
    public function logout(){
        //清除session null  作用域
       session(null,config('session.session_admin_scope'));
       $this->redirect('login/index');
    }
}