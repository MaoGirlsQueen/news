<?php


namespace app\api\controller\v1;


use app\api\controller\Common;
use app\common\lib\exception\ApiException;
use think\Exception;

class Rank extends Common
{
    /***
      获取排行榜
     * 1.获取数据库 根据readcount排序 5 - 10
     * 2、
     **/
   public function index(){
       try{
           $rands = model('News')->getRankNormalNews();
           $rands = $this->getNews($rands);
       }catch (Exception $e){
           throw new ApiException('error',400);
       }


       return show(1,'ok',$rands,200);
   }
}