<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
Route::get("test","api/v1.Test/index");
Route::put('test/:id','api/v1.Test/update');
Route::resource('test','api/v1.Test');
Route::get("api/:version/cat",'api/:version.Cat/read');
Route::get("api/:version/index",'api/:version.Index/index');
Route::resource("api/:version/news",'api/:version.News');
Route::get("api/:version/rank",'api/:version.Rank/index');