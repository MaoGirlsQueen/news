<?php


namespace app\api\controller\v1;

use app\common\lib\Aes;
use app\common\lib\IAuth;
use think\Exception;

class User extends AuthBase
{

    /***
      获取用户信息
     * 用户的基本信息非常隐私，需要加密处理
     **/
    public function read(){
       return show(1,'ok',(new Aes())->encrypt($this->user),200);
    }

    /***
    更新用户信息
     **/
    public function update(){
        $paramData = input('param.');
        $data =[];
        if(empty($paramData)){
            return show(0,'参数不合法',[],401);
        }
        if(!empty($paramData['image'])){
           $data['image'] = $paramData['image'];
        }
        if(!empty($paramData['username'])){
            $data['username'] = $paramData['username'];
        }
        if(!empty($paramData['sex'])){
            $data['sex'] = $paramData['sex'];
        }
        if(!empty($paramData['sign'])){
            $data['sign'] = $paramData['sign'];
        }
        if(!empty($paramData['password'])){
            $data['password'] = IAuth::setPassWord($paramData['password']);
        }
        if(empty($data)){
            return show(0,'参数不合法',[],404);
        }
        try{
            $id = model('User')->save($data,['id'=>$this->user->id]);

            if($id ){
                return show(1,'ok',[],202);
            }else{
                return show(0,'参数不合法',[],404);
            }

        }catch (Exception $e){
            return show(0,'参数不合法',[],500);
        }

    }
}