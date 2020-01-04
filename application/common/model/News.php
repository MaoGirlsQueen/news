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
        return $result ;
    }
}