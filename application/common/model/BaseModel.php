<?php


namespace app\common\model;


use think\Model;

class BaseModel extends Model
{
    protected $autoWriteTimestamp=true;
    public function add($data){
        if(!is_array($data)){
            exception('传递参数不合法');
        }

        $this->allowField(true)->save($data);
        return $this->id;
    }
}