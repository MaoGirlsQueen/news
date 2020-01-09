<?php


namespace app\api\controller\v1;


use app\api\controller\Common;
use app\common\lib\Aes;
use app\common\lib\Alidayu;
use app\common\lib\IAuth;

class Login extends Common
{
    public function save(){
        if(!request()->isPost()){
            return show(0,'login error',[],403);
        }
        //校验phone和code 是不是合法
        $param = input('param.');
        if(empty($param['phone'])){
            return show(0,'手机号码不合法',[],403);
        }
        if(empty($param['code'])){
            return show(0,'验证码不合法',[],403);
        }

        // 获取发送验证码的code
//        $code = Alidayu::checkSmsIndetify();
        $code = "2563";
        if($code !=$param['code']){
            $param['code'] = (new Aes())->decrypt($param['code']);
            return show(0,'验证码不存在',[],403);
        }

        $token = IAuth::setAppLoginToken($param['phone']);
        $data = [
            'token'=>$token,
            'time_out'=>strtotime("+".config('session.token_login_time_out')."days")
        ];
         $user = model("User")->get(['phone' => $param['phone']]);
         if($user && $user->status == 1){
             //更新
             $id = model("User")->save($data,['id'=>$user->id]);
         }else{
             $data["username"]='我的圈-'.$param['phone'];
             $data['status']=1;
             $data['phone']=$param['phone'];
             $id =  model("User")->add($data);
         }
        //第一次登录 注册数据

         $en_token = (new Aes())->encrypt($token."||".$id);
        if($id){
            $result = [
                'token' => $en_token
            ];
            return show(1,'OK',$result,200);
        }else{
            return show(0,'登录失败',[],400);
        }
    }
}