<?php


namespace app\common\model;


use think\Db;

class Comment extends BaseModel
{

    /**
      通过条件获取评论的数量
     **/
     public function getNomalCommentsCountByCondition($param=[]){

         $count = Db::table('ent_comment')->alias(['ent_comment'=>'a','ent_user'=>'b'])->join('ent_user','a.user_id=b.id and a.news_id='.$param['news_id'])->count();

         return $count;
     }

     /****
       根据条件获取数据
      **/
     public function getNormalCommentByCondition($param=[],$from=0,$size = 5){
         $result = Db::table('ent_comment')
             ->alias(['ent_comment'=>'a','ent_user'=>'b'])
             ->join('ent_user','a.user_id=b.id and a.news_id='.$param['news_id'])->limit($from,$size)->order('a.id','desc')->select();
            return $result;
     }
}