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
        $condition['status']= [
            'neq',config('code.status_delete')
        ];
        $order = ['id'=>'desc'];


        $result = $this->where($condition)->limit($from,$size)->order($order)->select();
        return $result;
    }
    //获取总数据
    public function  getNewsCountByCondition($condition=[]){
        $condition['status']= [
            'neq',config('code.status_delete')
        ];
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
        return ['id','title','image','read_count',"catid",'small_title'];
    }
}