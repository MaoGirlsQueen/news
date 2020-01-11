<?php


namespace app\api\controller\v1;


use app\common\model\UserNews;
use think\Exception;

class Upvote extends AuthBase
{
    public function save(){

        $id = input('post.id',0,'intval');

        if(empty($id)){
            return show(0,'id不存在',[],403);
        }

        $data = [
           'user_id' =>$this->user->id,
            'news_id'=>$id
        ];
        $user_news = model('UserNews')->get($data);

        if($user_news){
            return show(0,'已经点赞',[],401);
        }
        try{
            $userNewsId = model('UserNews')->add($data);
            if($userNewsId){
                model('News')->where(['id'=>$id])->setInc('upvote_count');
                return show(1,'ok',[],200);
            }else{
                return show(0,'点赞失败',[],500);
            }
        }catch (Exception $e){
            return show(0,$e->getMessage(),[],500);
        }
    }

    public function delete(){
      $id = input('delete.id');
        if(empty($id)){
            return show(0,'id不存在',[],403);
        }

        $data = [
            'user_id' =>$this->user->id,
            'news_id'=>$id
        ];
        $user_news = model('UserNews')->get($data);

        if(empty($user_news)){
            return show(0,'没有被点赞的文章',[],401);
        }
        try{
          $deletdId =  model('UserNews')->where($data)->delete();
          if($deletdId){
              model('News')->where(['id'=>$id])->setDec('upvote_count');
              return show(1,'ok',[],200);
          }else{
              return show(0,'删除失败',[],403);
          }
        }catch (Exception $e){
            return show(0,$e->getMessage(),[],500);
        }

    }
    /**
      判断是不是被点赞了
     **/
    public function read(){
        $id = input('param.id');
        if(empty($id)){
            return show(0,'id不存在',[],403);
        }
        $data = [
            'user_id' =>$this->user->id,
            'news_id'=>$id
        ];
        $user_news = model('UserNews')->get($data);

        if($user_news){
            return show(1,'ok',['isUpvote'=>1],200);
        }else{
            return show(0,'ok',['isUpvote'=>0],200);
        }

    }
}