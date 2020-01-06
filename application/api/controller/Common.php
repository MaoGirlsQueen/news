<?php


namespace app\api\controller;

/*
 * api公共控制器
 * ***/

use app\common\lib\exception\ApiException;
use app\common\lib\Time;
use think\Cache;
use think\Controller;
use app\common\lib\IAuth;
class Common extends Controller
{

    public $header = '';
    public function _initialize()
    {
      $this->checkRequestAuth();
//      $this->testAes();
    }
    /**
      检查每次app请求的数据是否合法
     **/
    public function checkRequestAuth(){
        // 首选获取头部信息headers
        $header = request()->header();
        //基础参数校验
        if(empty($header['sign'])){
            throw new ApiException('sign不存在',400);
        }

        //校验app_type
        if(!in_array($header['app_type'],config('app.apptypes'))){
            throw new ApiException('app_type类型不合法',400);
        }

        //
        $pass = IAuth::checkSignPass($header);
        if(!$pass){
            throw new ApiException("授权码失败",401);
        }
        Cache::set($header['sign'],1,config('app.app_sign_cache_time'));
        $this->header = $header;

    }

    public function testAes(){
        $times = (new Time())::get13Time();
        halt(ceil($times)/1000);
        $data = [
            'did'=>'12345gg',
            'version'=>1,
            'time'=>$times
        ];
       $signData = IAuth::setSign($data);
//        $data = 'ZGlkPTEyMzQ1Z2cmdmVyc2lvbj0x';
//
//        $__s = IAuth::getSign($data );
      echo $signData;exit;
    }

    /***
    对新闻栏目进行转换
     **/
    public function getNews($news = []){
        if(empty($news)){
            return null;
        }
        $cats = config('cat.lists');
        foreach ($news as $key => $new){
            $news[$key]['catname'] = $cats[$new['catid']] ? $cats[$new['catid']]:'-';
        }
        return $news;
    }
}