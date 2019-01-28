<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/20
 * Time: 23:29
 */
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BaseController extends Controller{

    /**
     * 错误跳转
     * @param $msg
     */
    protected function error($msg){
        return redirect()->route('home');
    }
    /**
     * 将二维对象转化为数组
     * @param $array
     * @return array
     */
    protected function object_get_array($array)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = (array)$value;
            }
        }
        return $array;
    }

    /** 将一维对象转化为数组
     * @param $array
     * @return array
     */
    protected function object_first_array($array){
        if (is_object($array)) {
            $array = (array)$array;
        }
        return $array;
    }
}