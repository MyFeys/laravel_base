<?php
//文件上传接口，前后台共用
Route::post('uploadImg', 'PublicController@uploadImg')->name('uploadImg');
//发送短信
Route::post('/sendMsg', 'PublicController@sendMsg')->name('sendMsg');

Route::get('/','Home\IndexController@index')->name('home');

Route::get('list/{id}','Home\IndexController@list', function ($id) {
    // 只有当 {id} 是数字时才会被调用
});

Route::get('info/{id}','Home\IndexController@info')->name('info');

Route::get('pages/{id}','Home\IndexController@pages')->name('pages');

//支付
Route::group(['namespace' => 'Home'], function () {
    //微信支付
    Route::get('/wechatPay', 'PayController@wechatPay')->name('wechatPay');
    //微信支付回调
    Route::post('/wechatNotify', 'PayController@wechatNotify')->name('wechatNofity');
});

//会员-不需要认证
Route::group(['namespace'=>'Home','prefix'=>'member'],function (){
    //注册
    Route::get('register', 'MemberController@showRegisterForm')->name('home.member.showRegisterForm');
    Route::post('register', 'MemberController@register')->name('home.member.register');
    //登录
    Route::get('login', 'MemberController@showLoginForm')->name('home.member.showLoginForm');
    Route::post('login', 'MemberController@login')->name('home.member.login');
});
//会员-需要认证
Route::group(['namespace'=>'Home','prefix'=>'member','middleware'=>'member'],function (){
    //个人中心
    Route::get('/','MemberController@index')->name('home.member');
    //退出
    Route::get('logout', 'MemberController@logout')->name('home.member.logout');
});

/*
Route::any('/{module?}/{controller?}/{function?}',function($module='',$controller='',$function=''){

    if(!empty($module) && !empty($controller) && !empty($function)){
        $module = ucfirst($module);
        $controller = ucfirst($controller);
        $str = 'App\Http\Controllers\\'.$module.'\\'.$controller.'Controller';
        // echo "$str";
        $result = new $str();
        if(method_exists($result, $function)){
            return $result->$function();
        }else{
            return abort(404);
        }
    }elseif(!empty($module) && !empty($controller) && empty($function)){
        $module = ucfirst($module);
        $str = 'App\Http\Controllers\\'.$module.'Controller';
        // echo "$str";die;
        $result = new $str();
        if(method_exists($result, $controller)){
            return $result->$controller();
        }else{
            return abort(404);
        }
    }elseif(!empty($module) && empty($controller) && empty($function)){
        $module = ucfirst($module);
        $str = 'App\Http\Controllers\\'.$module.'Controller';
        $result = new $str();
        $controller = 'index';
        if(method_exists($result, $controller)){
            return $result->$controller();
        }else{
            return abort(404);
        }
    }else{
        $str = 'App\Http\Controllers\IndexController';
        $result = new $str();
        $controller = 'index';
        if(method_exists($result, $controller)){
            return $result->$controller();
        }else{
            return abort(404);
        }
    }
});*/
