<?php


namespace app\admin\controller;


use think\Exception;

class News extends Base
{
    public function index(){
        $paramsData = input('param.');
        //获取数据的模式一
       //$data = model('News')->getNews();

        // 获取数据的模式二
        $whereData =[];
        $this->getPageAndSize($paramsData);
        $whereData['page'] = $this->page;
        $whereData['size'] = $this->size;
           // 获取数据表的数据
        $data = model('News')->getNewsByCondition($whereData);

       //获取满足条件的有多少数据
        $total = model('News')->getNewsCountByCondition($whereData);

        // 结合总数+size 分页有多少页
        $pageTotal = ceil($total/$whereData['size']);
        return $this->fetch('',[
            "news"=>$data,
            'pageTotal'=>$pageTotal,
            'curr'=>$whereData['page']
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