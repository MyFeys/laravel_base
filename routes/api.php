<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//定义路由分组
Route::middleware([])->namespace('api')->prefix('')->group(function() {
    //定义控制器路由
    Route::any('/{controller?}/{function?}',function($controller='',$function=''){
        $module = 'Api'; //如果修改api接口路径这里也要修改
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
    });
});
