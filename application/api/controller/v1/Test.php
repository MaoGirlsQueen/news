<?php


namespace app\api\controller\v1;


class Test extends AuthBase
{
    public function save(){
        halt($this->user);
    }
}