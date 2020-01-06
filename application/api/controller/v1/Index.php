<?php


namespace app\api\controller\v1;


use app\api\controller\Common;

class Index extends Common
{
     /***
       获取首页接口
      * 1.头图
      * 2、推荐位列表
      **/
     public function index(){
         $heads = model('News')->getIndexHeadNormalNews();
         $heads = $this->getNews($heads);
         $positions = model('News')->getPositionNormalNews();
         $positions = $this->getNews($positions);
         $result = [
             'heads'=>$heads,
             'positions'=>$positions
         ];
         return show(config('code.app_show_success'),'Ok',$result,200);
     }
}