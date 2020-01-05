<?php


namespace app\admin\controller;


use think\Exception;

class News extends Base
{
    public function index(){
        $paramsData = input('param.');
        $query = http_build_query($paramsData);
        $whereData =[];
        //转换查询条件
        if(!empty($paramsData['start_time']) && !empty($paramsData['end_time']) && $paramsData['end_time'] >=$paramsData['start_time']){
            $whereData['create_time'] =[
              ['gt',strtotime($paramsData['start_time'])] , ['lt',strtotime($paramsData['end_time'])] ,
            ];
        }
        if(!empty($paramsData['catid'])){
            $whereData['catid'] = intval($paramsData['catid']);
        }
        if(!empty($paramsData['title'])){
            $whereData['title'] = ['like','%'.$paramsData['title'].'%'];
        }
        //获取数据的模式一
       //$data = model('News')->getNews();

        // 获取数据的模式二

        $this->getPageAndSize($paramsData);

           // 获取数据表的数据
        $data = model('News')->getNewsByCondition($whereData,$this->from,$this->size);

       //获取满足条件的有多少数据
        $total = model('News')->getNewsCountByCondition($whereData);

        // 结合总数+size 分页有多少页
        $pageTotal = ceil($total/$this->size);
        return $this->fetch('',[
            'cat'=>config('cat.lists'),
            "news"=>$data,
            'pageTotal'=>$pageTotal,
            'curr'=>$this->page,
            'start_time'=>empty($paramsData['start_time']) ? '':$paramsData['start_time'],
            'end_time'=>empty($paramsData['end_time']) ? '':$paramsData['end_time'],
            'catid'=>empty($paramsData['catid']) ?'':$paramsData['catid'],
            'title'=>empty($paramsData['title']) ?'':$paramsData['title'],
            'query'=>$query
        ]);
    }


   public function add(){
       if(request()->isPost()){
           $data = input('post.');
           //验证数据
           //数据入库
           try{
              $id = model('News')->add($data);
           }catch (Exception $e){
               return $this->result('',0,'新增失败');
           }

           if($id){
               return $this->result(['jump_url'=>url("news/index")],1,'OK');
           }else{
               return $this->result('',0,'新增失败');
           }
       }
       return $this->fetch('',['cats'=>config('cat.lists')]);
   }



}