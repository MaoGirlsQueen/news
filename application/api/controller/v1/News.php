<?php


namespace app\api\controller\v1;


use app\api\controller\Common;
use app\common\lib\exception\ApiException;
use think\Exception;

class News extends Common
{
   public function index(){
       //id校验
       $data = input('get.');
       $whereData['status'] = config('code.status_normal');
       if(!empty($data['catid'])){
           $whereData['catid'] = input('get.catid','0','intval');
       }

       if(!empty($data['title'])){
           $whereData['title'] = ['like','%'.$data['title'].'%'];
       }


       $this->getPageAndSize($data);
       $count =   model("News")->getNewsCountByCondition($whereData);
       $news = model('News')->getNewsByCondition($whereData,$this->from,$this->size);
       $news = $this->getNews($news);
       $result = [
           'total'=>$count,
           'page_num'=>ceil($count/$this->size),
           'list'=>$news
       ];
       return show(1,"ok",$result,200);
   }
   /***
     获取详情数据
    **/
   public function read(){
       $id = input('param.id');
       if(empty($id)){
           throw new ApiException('该详情id不存在',400);
       }

           $detail = model('News')->getDetailNormalNews($id);
           $detail = $this->getNews($detail);
           if(empty($detail)){
               throw new ApiException('该详情不存在',400);
           }
           model("News")->where(['id'=>$id])->setInc('read_count');
           $cats = config('cat.lists');
          $detail->catname = $cats[$detail->catid];
       return show(1,'ok',$detail,200);
   }
}