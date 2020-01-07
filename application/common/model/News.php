<?php


namespace app\common\model;


class News extends BaseModel
{


      //获取信息内容分页
    public function getNews($data=[]){
        $data['status']= [
            'neq',config('code.status_delete')
        ];
        $order = ['id'=>'desc'];
        $result = $this->where($data)->order($order)->paginate();

        //php内置的调试生气了、语句

        return $result ;
    }

    //获取指定的页数和大小
    public function getNewsByCondition($condition=[],$from=0,$size=5){
       if(!isset($condition['status'])){
           $condition['status']= [
               'neq',config('code.status_delete')
           ];
       }
        $order = ['id'=>'desc'];


        $result = $this->where($condition)->field($this->_getField())->limit($from,$size)->order($order)->select();
        return $result;
    }
    //获取总数据
    public function  getNewsCountByCondition($condition=[]){
        if(!isset($condition['status'])){
            $condition['status']= [
                'neq',config('code.status_delete')
            ];
        }
        return $this->where($condition)->count();
    }

    /***
       获取首页头图的数据
     **/
    public function getIndexHeadNormalNews($num =5){
       $data = [
           'status'=>1,
           'is_head_figure'=>1
       ];
       $order = [
           'id'=>'desc'
       ];
       return $this->where($data)->field($this->_getField())->order($order)->limit($num)->select();
    }

    /****
       获取推荐列表
     **/
    public function getPositionNormalNews($num =5){
        $data = [
            'status'=>1,
            'is_position'=>1
        ];
        $order = [
            'id'=>'desc'
        ];
        return $this->where($data)->field($this->_getField())->order($order)->limit($num)->select();
    }

    /***
      通用化字段处理
     **/

    private function _getField(){
        return ['id','title','image','read_count',"catid",'small_title','update_time','is_position','status','create_time'];
    }


    /****
    获取排行列表
     **/
    public function getRankNormalNews($num =5){
        $data = [
            'status'=>1
        ];
        $order = [
            'read_count'=>'desc'
        ];
        return $this->where($data)->field($this->_getField())->order($order)->limit($num)->select();
    }
   /**
     获取详情页内容
    **/
   public function getDetailNormalNews($id){
       $data = [
           'status'=>1,
           'id'=>$id
       ];
       return $this->where($data)->field($this->_getDetail())->find();
   }

   private function _getDetail(){
       return ['id','title','read_count','status','create_time','content','small_title',"catid",'upvote_count','comment_count'];
   }
}