<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use DB;
use File;
use Storage;

class mysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mysql:name {strValue=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatic generation of database tables for the controller and front-end view';

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
        $orimysqlname = $this->argument('strValue');
        if (empty($orimysqlname)){
            $orimysqlname = $this->ask('Please enter a database table name ?');
        }
        if (strpos($orimysqlname,'/')){
            $arrayname = explode('/',$orimysqlname);
            $totalnum = count($arrayname);
            $numname = $totalnum - 1;
            $mysqlname = $arrayname[$numname];
            for ($x=0; $x< $numname; $x++) {
                $path[] = $arrayname[$x];
            }
            $pathurl = implode('/',$path);
        }else{
            $mysqlname = $orimysqlname;
            $pathurl = 0;
        }
        echo 'The database name entered is:'.$mysqlname.' If you find this database table, you will create the CRUD model for you!';
        echo "\n \n";
        $tables = array_map('reset', \DB::select('SHOW TABLES'));
        $tables = DB::select('show tables');
        $tables = array_column($tables, 'Tables_in_toozanqun');
        $isdataname = in_array("{$mysqlname}",$tables);
        if ($isdataname){
            $Controllername = $pathurl.'/'.$mysqlname.'Controller';
            //创建视图
            $oritem = app_path('Console/template/Views/index.blade.php');
            if (!empty($pathurl)){
                $pathsys = resource_path().'/views/'.$pathurl;
                $file = File::isDirectory($pathsys) or File::makeDirectory($pathsys, 0777, true, true);
                $view = copy($oritem,$pathsys.'/index.blade.php');
                var_dump($view);
                echo '已创建视图文件到'.$pathsys;
            }else{
                $pathsys = resource_path();
                $view = copy($oritem,$pathsys.'/index.blade.php');
                var_dump($view);
                echo '已创建视图文件到'.$pathsys;
            }
            //创建控制器
            system("php artisan make:controller {$Controllername} --resource");
            //创建模型
            system("php artisan make:model Models/{$mysqlname}");
        }else{
            echo "\n\n Please check if your database name is correct!";
        }
    }
}
