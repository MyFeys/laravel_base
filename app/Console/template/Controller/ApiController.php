<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ApiController extends jicheng
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
     * 数据列表
     * Date: 2019/1/28 0028
     * Time: 下午 3:39
     */
    public function lists(){
        return 'list content';
    }

    /**
     * 数据搜索
     * Date: 2019/1/28 0028
     * Time: 下午 4:44
     */
    public function search(){
        return 'search content';
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
