<?php


namespace app\admin\controller;


use think\Exception;

class News extends Base
{
   public function add(){
       if(request()->isPost()){
           $data = input('post.');
           //验证数据
           //数据入库
           try{
              $id = model('News')->add($data);
           }catch (Exception $e){
               return $this->result('',0,'新增失败');
           }

           if($id){
               return $this->result(['jump_url'=>url("news/index")],1,'OK');
           }else{
               return $this->result('',0,'新增失败');
           }
       }
       return $this->fetch('',['cats'=>config('cat.lists')]);
   }
   public function index(){
       $data = model('News')->getNews();
       return $this->fetch('',[
           "news"=>$data
       ]);
   }
}