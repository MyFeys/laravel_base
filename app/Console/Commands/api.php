<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class api extends Command
{
    /**
     * The name and signature of the console command.
     *  interface_name 接口名称，如果是folder/file 将取/最后一个名字为接口名字
     *  t 操作方式 0删除 1创建
     * @var string
     */
    protected $signature = 'api
                            {interface_name}
                            {--T|t=1}';
    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Quickly create API interfaces and routes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arguments = $this->arguments('interface_name');
        if (empty($arguments)){
            $this->ask('Please enter the API interface name ?');
        }
        $interface_name = $arguments['interface_name'];
        if (strpos($interface_name,'/')){
            $arrayname = explode('/',$interface_name);
            $totalnum = count($arrayname);
            $numname = $totalnum - 1;
            $mysqlname = $arrayname[$numname];
            for ($x=0; $x< $numname; $x++) {
                $path[] = $arrayname[$x];
            }
            $pathurl = 'Api/'.implode('/',$path);
        }else{
            $mysqlname = $interface_name;
            $pathurl = 'Api/';//默认接口文件在API，如果想改变，请修改这里
        }
        $dmysqlname = ucfirst(strtolower($mysqlname));
        // 获取所有选项...
        $options = $this->options();
        $t = $options['t'];//是否创建:1=创建CURD,0=删除CURD
        //删除相关接口及路由
        if (empty($t)){
            $q = $this->ask('If you delete this interface file, it will be unrecoverable! Please enter yes or no ');
            if ($q == 'yes'){
                //执行删除
                $Controllername = $pathurl.'/'.$dmysqlname.'Controller';
                //删除控制器
                $controller = app_path("Http/Controllers/{$Controllername}.php");
                $delcontroller = @unlink($controller);
                if ($delcontroller){
                    echo 'delete ok';
                }
            }else{
                $this->error('exit successfully!');
            }
        }else{
            //创建相关接口及路由文件
            $Controllername = $pathurl.'/'.$dmysqlname.'Controller';
            //创建路由
            $addroutes = $this->addroutes($mysqlname,$dmysqlname,$Controllername);
            var_dump($addroutes);
            //创建控制器
            $addcontroller = $this->addcontroller($mysqlname,$dmysqlname,$Controllername);
            var_dump($addcontroller);
        }
    }
    /**
     * 创建控制器
     * @param $mysqlname
     * @param $dmysqlname
     * @param $Controllername
     * Date: 2019/1/28 0028
     * Time: 下午 5:31
     */
    protected function addcontroller($mysqlname,$dmysqlname,$Controllername){
        $controllers = app_path('Console/template/Controller/ApiController.php');//控制器原文件
        $dConname = ucfirst(strtolower($mysqlname)).'Controller';
        $path = app_path('Http/Controllers/'.$Controllername.'.php');//控制器新文件
        $res = $this->modelreplace($controllers,$path,'ApiController',$dConname);
        $basepath = app_path('Http/Controllers/BaseController.php');
        if (file_exists($basepath)){
            $res = $this->modelreplace($controllers,$path,'jicheng','BaseController');
        }
        if ($res){
            return 'controller ok';
        }else{
            return 'controller fall';
        }
    }
    /**
     * 创建api接口相关路由
     * @param $mysqlname
     * @param $dmysqlname
     * @param $Controllername
     * Date: 2019/1/28 0028
     * Time: 下午 3:05
     */
    protected function addroutes($mysqlname,$dmysqlname,$Controllername){
        $routes = app_path('Console/template/routes/api.php');//路由原文件
        $path = base_path('routes/api.php');//路由新文件
        if (file_exists($path)){
            $cpfile = @copy($routes,$path);
            if ($cpfile){
                return 'Route ok';
            }else{
                return 'Route fall';
            }
        }else{
            return 'Route already exists. Route ok';
        }
    }

    /**
     * 不含大写替换，直接给字段替换
     * @param $file_name
     * @param $fwritefile
     * @param $tag
     * @param $mysqlname 替换的文件
     *
     * @return bool
     * Date: 2018/11/22 0022
     * Time: 下午 10:45
     */
    protected function modelreplace($file_name,$fwritefile,$tag,$mysqlname){
        $file = file_exists($fwritefile);
        if ($file){
            $fp=fopen($fwritefile,'r');
        }else{
            $fp=fopen($file_name,'r');
        }
        $data = [];
        while(!feof($fp))
        {
            $buffer=fgets($fp,4096);
            //替换文件
            $buffer = str_replace($tag,$mysqlname,$buffer);//替换小写tag
            $data[] = $buffer;
        }
        $numbytes = file_put_contents($fwritefile, $data);//写入路径
        fclose($fp);
        if($numbytes){
            return true;
        }else{
            return false;
        }
    }
}
