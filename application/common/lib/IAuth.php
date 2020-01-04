<?php


namespace app\common\lib;



class IAuth
{
    /***
    用户权限相关
    **/
     public static function setPassWord($data){
         return md5($data.config('app.admin_password_solt'));
     }
}