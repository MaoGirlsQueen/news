<?php


namespace app\api\controller\v1;

use app\api\controller\Common;
class Cat extends Common
{
    public function read(){
        $cats = config('cat.lists');
        $result[] =[
            'catid'=>0,
            'catname'=>'首页'
        ];
        foreach ($cats as $catid => $catname){
            $result[] = [
                'catid'=>$catid,
                'catname'=>$catname
            ];
        }

        return show(config('code.app_show_success'),'Ok',$result,200);
    }

}