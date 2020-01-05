<?php


namespace app\admin\controller;


use think\Controller;

class Base extends Controller
{

    public $page =0;
    public $size=0;
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

    /**
      获取分页的内容和size
     **/
    public function getPageAndSize($paramsData){

       $this->page = !empty($paramsData['page']) ? $paramsData['page']: 1;
       $this->size = !empty($paramsData['size']) ? $paramsData['size']: config('paginate.list_rows');
    }
}