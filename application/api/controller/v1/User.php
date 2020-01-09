<?php


namespace app\api\controller\v1;

class User extends AuthBase
{
    public function save(){
        halt($this->user);
    }
}