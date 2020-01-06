<?php


namespace app\api\controller;


use think\Controller;

class Time extends Controller
{
    public function index(){
        return show(config('code.app_show_success'),'ok',time());
    }

}