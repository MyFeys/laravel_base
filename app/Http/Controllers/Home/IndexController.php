<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends BaseController
{

    protected $pagenum = 5; //定义分页条数
    protected $ismobile = false;

    /**
     * 判断手机端还是电脑端
     * IndexController constructor.
     */
    public function __construct()
    {
        $ispc = isMobile();
        if ($ispc || strpos($_SERVER['HTTP_USER_AGENT'],'Mobile')!==false){
            //手机端
            $this->ismobile = true;
        }
    }

    /**
     * 前台首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'nav' => $this->navs(),
            'advert' => $this->advert(),
        ];
        if ($this->ismobile){
            return view("mobile/index",$data);
        }
        return view("home/index",$data);
    }

    /**
     * 顶部导航
     * @return mixed
     */
    protected function navs(){
        //顶部导航
        $categories = DB::table('categories')
            ->orderBy('sort','asc')
            ->orderBy('id','asc')
            ->get();
        return $categories;
    }
    /**
     * 广告信息
     * @return mixed
     */
    protected function advert(){
        //广告信息
        $advert = DB::table('adverts')
            ->where('position_id','1')
            ->orderby('sort','asc')
            ->orderby('id','desc')
            ->get();
        return $advert;
    }
    /**
     * 前台信息列表
     */
    public function list($id){
        if (empty($id)){
            return $this->error('类别错误');
        }
        $classname = DB::table('categories')
            ->where('id',$id)
            ->value('name');
        if (empty($classname)){
            return $this->error('类别错误');
        }
        $lists = DB::table('articles')
            ->where('category_id',$id)
            ->orderby('sort','asc')
            ->orderby('id','desc')
            ->paginate($this->pagenum);

        $data = [
            'lists' => $lists,
            'classname' => $classname,
            'advert' => $this->advert(),
            'nav' => $this->navs(),
        ];
        if ($this->ismobile){
            return view("mobile/list",$data);
        }
        return view("home/list",$data);
    }

    /**
     * 信息详情页
     */
    public function info($id){
        if (empty($id)){
            return $this->error('类别错误');
        }
        $infos = DB::table('articles')
            ->where('id',$id)
            ->first();
        if (empty($infos)){
            return $this->error('无此信息ID');
        }
        //点击次数
        DB::table('articles')->where('id',$id)->increment('click', 2);
        //分类
        $classname = DB::table('categories')
            ->where('id',$infos->category_id)
            ->first();
        //上一篇
        $upaction = DB::table('articles')
            ->where('id','<',$id)
            ->orderby('id','asc')
            ->first();
        $empty = [
            'id' => '',
            'title' => '返回首页',
        ];
        if (empty($upaction)){
            $upaction = (object)$empty;
        }
        //下一篇
        $next_article = DB::table('articles')
            ->where('id','>',$id)
            ->orderby('id','asc')
            ->first();
        if (empty($next_article)){
            $next_article = (object)$empty;
        }
        $data = [
            'infos' => $infos,
            'advert' => $this->advert(),
            'nav' => $this->navs(),
            'previous' => $upaction, //上一篇
            'next_article' => $next_article, //下一篇
            'classname' => $classname, //分类名称
        ];
        if ($this->ismobile){
            return view("mobile/info",$data);
        }
        return view("home/info",$data);
    }

    /**
     * 单页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pages($id){
        if (empty($id)){
            return $this->error('类别错误');
        }
        $infos = DB::table('pagescl')
            ->where('id',$id)
            ->first();
        if (empty($infos)){
            return $this->error('无此信息ID');
        }
        //点击次数
        DB::table('pagescl')->where('id',$id)->increment('click', 2);
        $data = [
            'infos' => $infos,
            'advert' => $this->advert(),
            'nav' => $this->navs(),
        ];
        if ($this->ismobile){
            return view("mobile/pages",$data);
        }
        return view("home/pages",$data);
    }
}
