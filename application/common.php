<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function pagination($obj){
    if(!$obj){
        return '';
    }
    $params = request()->param();
    return '<div class="imooc-app">'.$obj->appends($params)->render().'</div>';
}


/**
  分类格式化
 **/
function getCatName($catId){
    if(!$catId){
        return null;
    }
    $cats = config('cat.lists');
    return !empty($cats[$catId]) ? $cats[$catId]:'';
}

/**
是否推荐格式化
 */
function getPosition($id){
    return $id ? '<span style="color:red">是</span>':'<span>否</span>';
}

/**
发布状态格式化
 **/
function getStatus($id,$status){
    $model = request()->controller();
    $sta = $status == 1? 0:1;
    $url = url($model.'/status',['id'=>$id,'status'=>$sta]);
    if($status == 1){
        $str = "<a href='javascript:;' title='修改状态' status-url='".$url."' onclick='app_status(this)'><span class='label label-success radius'>正常</span></a>";
    }else if($status == 0){
        $str = "<a href='javascript:;' title='修改状态' status-url='".$url."' onclick='app_status(this)'><span class='label label-danger'>待审</span></a>";
    }
    return $str;
}

/***
  通用化API接口数据输出
 **/
function show($status,$message,$data=[],$httpCode=200){
    $result = [
        'status'=>$status,
        'message'=>$message,
        'data'=>$data,
    ];
    return json($result,$httpCode);
}