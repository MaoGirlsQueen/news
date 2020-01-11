<?php


namespace app\api\controller\v1;


use think\Exception;

class Comment extends AuthBase
{

    /***
       回复评论功能开发
     **/
   public function save(){
      $data = input('post.');
      //验证参数
       //newsid是不是存在
       $data['user_id'] = $this->user->id;
       try{
          $comment =  model("Comment")->add($data);
          if($comment){
              return show(1,'ok',[],200);
          }else{
              return show(0,'commnet error',[],400);
          }
       }catch (Exception $e){
           return show(0,'error',$e->getMessage(),400);
       }
   }

   /***
   查询评论列表 关联查询
    **/
   public function read(){
      $newsID = input('param.id');
       if(empty($newsID)){
           return show(0,'id不存在',[],403);
       }

       $param = ['news_id'=>$newsID];
       $this->getPageAndSize($param);
       $count = model('Comment')->getNomalCommentsCountByCondition($param);
       $result = model('Comment')->getNormalCommentByCondition($param,$this->from,$this->size);

       $data = [
           'total'=>$count,
           'page_num'=>ceil($count/$this->size),
           'list'=>$result
       ];
       return show(1,'ok',$data,200);
   }
}