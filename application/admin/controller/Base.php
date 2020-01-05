<?php


namespace app\admin\controller;


use think\Controller;
use think\Exception;

class Base extends Controller
{

    public $page =0;
    public $size=0;
    public $from=0;
    //控制器名
    public $model = '';
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
       $this->from = ($this->page - 1)*$this->size;
    }


    /**
    删除功能
     **/

   public function delete($id=0){
     if(!intval($id)){
         return $this->result('',0,'ID不合法');
     }
     //通过save形式更新数据库
       //获取控制器的名字 当表明和控制器名一样的时候
       //b不一样的时候 在当前的控制器方法的前边放$this->model='当期控制器的名字'
       $model = $this->model ? $this->model : request()->controller();

       // 如果是php7以上的版本  $model = $this->model ?? request()->controller() 等同于  $this->model ? $this->model : request()->controller()
       try{
           $res= model($model)->save(['status'=>-1],['id'=>$id]);
       }catch (Exception $e){
           return $this->result('',0,$e->getMessage());
       }
       if($res){
           //$_SERVER['HTTP_REFERER'] 这个页面来自哪里
           return $this->result(['jump_url'=> $_SERVER['HTTP_REFERER']],1,'OK');
       }
       return $this->result('',0,'删除失败');
   }

   /**
   修改状态
    **/
    public function status(){
        $data = input('param.');
        //通过save形式更新数据库
        //获取控制器的名字 当表明和控制器名一样的时候
        //b不一样的时候 在当前的控制器方法的前边放$this->model='当期控制器的名字'
        $model = $this->model ? $this->model : request()->controller();

        // 如果是php7以上的版本  $model = $this->model ?? request()->controller() 等同于  $this->model ? $this->model : request()->controller()
        try{
            $res= model($model)->save(['status'=>$data['status']],['id'=>$data['id']]);
        }catch (Exception $e){
            return $this->result('',0,$e->getMessage());
        }
        if($res){
            //$_SERVER['HTTP_REFERER'] 这个页面来自哪里
            return $this->result(['jump_url'=> $_SERVER['HTTP_REFERER']],1,'OK');
        }
        return $this->result('',0,'操作失败');
    }
}