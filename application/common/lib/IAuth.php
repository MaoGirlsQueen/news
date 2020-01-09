<?php


namespace app\common\lib;


use app\common\lib\Aes;
use think\Cache;

class IAuth
{
    /***
    用户权限相关
    **/
     public static function setPassWord($data){
         return md5($data.config('app.admin_password_solt'));
     }

     /**
         设置sign
      **/
     public static function setSign($data=[]){
         //1.按字段排序
         ksort($data);
         //2.把数组转成&拼接的字符串
         $string = http_build_query($data);
         //3.通过aes加密
         $data = (new Aes())->encrypt($string);
//         //4.把加密的字符串转成大写
//         $newData = strtoupper($data);
         return $data;
     }
     public static function getSign($data=''){
         $signData= (new Aes())->decrypt($data);
         return $signData;
     }

     /***
     检查 sign和传递的参数 是不是正常
      */
     public static function checkSignPass($data){
         //解密

        $string =self::getSign($data['sign']);
        if(empty($string)){
            return false;
        }
        //&链接的字符串转成数组
         parse_str($string,$arr);
         if(!is_array($arr) || empty($arr['did']) || $arr['did']!=$data['did']){
             return false;
         }
//         if(!config("app_debug")){
//             if(($data['time'] - (ceil($arr['time']))/1000)>config('app.app_sign_time')){
//                 return false;
//             }
//             if(Cache::get($data['sign'])){
//                 return false;
//             }
//         }

         return true;
     }

     /***
        设置登录的token 唯一性
      **/

     public static function setAppLoginToken($phone = ''){
         $str = md5(uniqid(md5(microtime(true)),true));
         $str = sha1($str.$phone);
         return $str;
     }

}