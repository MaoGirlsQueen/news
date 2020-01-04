<?php


namespace app\admin\controller;
use app\common\lib\IAuth;

use think\Controller;
use think\Exception;

class Admin extends Controller
{
     public function add(){

         //判断是否是post提交
         if(request()->isPost()){
           $data = input("post.");
           $validate = validate('AdminUser');
           $result = $validate->check($data);
           if(!$result){
               $this->error($validate->getError());
           }
           $data['password']= IAuth::setPassWord($data['password']);
           $data['status']=1;

           try{
               $id = model('AdminUser')->add($data);
           }catch (Exception $e){
               $this->error($e->getMessage());
           }
           if($id){
               $this->success('id='.$id.'新增成功');
           }else{
               $this->error('error');
           }
         }else{
             return $this->fetch();
         }

     }
}