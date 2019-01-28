<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    /**
     * api入口文件
     * @return string
     * Date: 2019/1/28 0028
     * Time: 下午 3:38
     */
    public function index(){
        return 'Welcome to the API interface';
    }

    /**
     * 增加数据
     * Date: 2019/1/28 0028
     * Time: 下午 3:39
     */
    public function add(){
        return 'add content';
    }

    /**
     * 编辑数据
     * Date: 2019/1/28 0028
     * Time: 下午 3:39
     */
    public function edit(){
        return 'edit content';
    }

    /**
     * 删除数据
     * Date: 2019/1/28 0028
     * Time: 下午 3:40
     */
    public function delete(){
        return 'delete content';
    }

}
