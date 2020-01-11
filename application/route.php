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
Route::resource('test','api/Test');
Route::get("api/:version/cat",'api/:version.Cat/read');
Route::get("api/:version/index",'api/:version.Index/index');
Route::resource("api/:version/news",'api/:version.News');
Route::get("api/:version/rank",'api/:version.Rank/index');
Route::resource("api/:version/identify",'api/:version.Identify');
Route::post("api/:version/login",'api/:version.Login/save');
Route::resource("api/:version/user",'api/:version.User');
Route::post("api/:version/image",'api/:version.Image/save');
Route::post("api/:version/upvote",'api/:version.Upvote/save');
Route::delete("api/:version/upvote",'api/:version.Upvote/delete');
Route::get("api/:version/upvote/:id",'api/:version.Upvote/read');
Route::post("api/:version/comment",'api/:version.Comment/save');
Route::get("api/:version/comment/:id",'api/:version.Comment/read');