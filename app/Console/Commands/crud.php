<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use DB,File,Storage;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\PermissionCreateRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Models\Permission;
/**
 * 一键生成CRUD命令行
 * crud
 */
class crud extends Command
{
    /**
     * The name and signature of the console command.
     *  strValue 路径名称
     *  t 操作方式 0删除 1创建
     *  n 菜单名称（管理菜单的名称）
     *  c 控制器别名
     *  d 占位 暂无用
     * @var string
     */
    protected $signature = 'crud:table 
                            {strValue=0}
                            {--T|t=1}
                            {--N|n=0}
                            {--C|c=0} 
                            {--D|d=1}';
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
        // 获取所有选项...
        $options = $this->options();
        $t = $options['t'];//是否创建:1=创建CURD,0=删除CURD
        $c = $options['c'];//控制器名称
        $N = $options['n'];//菜单名称
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
            $pathurl = '';
        }
        $tables = array_map('reset', \DB::select('SHOW TABLES'));
        $tables = DB::select('show tables');
        $tablearray = json_encode($tables);
        if (strpos($tablearray,'Tables_in')){
            $tablesarray = $this->object_array($tables);
        }else{
            $tablesarray = [];
        }
        if (empty($tablesarray)){
            return $this->error('The database is empty, please add the data table first');
        }else{
            $Tables_in = key($tablesarray[0]);
        }
        $tables = array_column($tables, $Tables_in);
        $isdataname = in_array("{$mysqlname}",$tables);
        if ($isdataname){
//            $columns = Schema::getColumnListing($mysqlname);
//            dd($columns);
            $columns = DB::select("SHOW FULL COLUMNS FROM {$mysqlname}");
            $field = [];
            foreach ($columns as $key=>$val){
                $fieldstr = $val->Field;
                $fielddec = $val->Comment;//字段描述
                $fieldtype = $val->Type;
                $check = $val->Null;
                $field[] = [
                    'field' => $fieldstr,
                    'fielddec' => $fielddec,
                    'fieldtype' => $fieldtype,
                    'check' => $check,
                ];
            }
            echo "\n";
            if (!empty($c)){
                $mysqlname = $c;
            }
            $dmysqlname = ucfirst(strtolower($mysqlname));
            $Controllername = $pathurl.'/'.$dmysqlname.'Controller';
            if (!empty($pathurl)){
                $pathsys = resource_path().'/views/'.$pathurl.'/'.$mysqlname;
                $file = File::isDirectory($pathsys) or File::makeDirectory($pathsys, 0777, true, true);
            }else{
                $pathsys = resource_path();
            }
            //删除相关CURD
            if (empty($t)){
                $q = $this->ask('Please confirm whether to delete the relevant CURD. Input 1 if yes, and 0 if no ?');
                if (!empty($q)){
                    $this->info('Delete relevant CURD processing, please wait!');
                    //删除追加路由
                    $target = "//---$mysqlname---start";
                    $targets = "//---$mysqlname---stop";
                    $this->delTargetLine($mysqlname,$target,$targets);
                    $s = "//-$mysqlname-start";
                    $d = "//-$mysqlname-stop";
                    $this->delTargetLine($mysqlname,$s,$d);
                    //删除视图
                    $view = $pathsys.'/_form.blade.php';
                    $delview = @unlink($view);
                    $view = $pathsys.'/create.blade.php';
                    $delview = @unlink($view);
                    $view = $pathsys.'/edit.blade.php';
                    $delview = @unlink($view);
                    $view = $pathsys.'/_cform.blade.php';
                    $delview = @unlink($view);
                    $view = $pathsys.'/_js.blade.php';
                    $delview = @unlink($view);
                    $view = $pathsys.'/index.blade.php';
                    $delview = @unlink($view);
                    if ($delview){
//                        echo $view;
                        $this->info('View file deleted successfully!');
                    }else{
//                        echo $view;
                        $this->error('View file deletion failed, please manually confirm whether there are residues!');
                    }
                    //删除控制器
                    $controller = app_path("Http/Controllers/{$Controllername}.php");
                    $delcontroller = @unlink($controller);
                    if ($delcontroller){
//                        echo $controller;
                        $this->info('Controller file deleted successfully!');
                    }else{
//                        echo $controller;
                        $this->error('The deletion of the controller file has failed. Please manually confirm whether there are residues!');
                    }
                    //删除模型
                    $model = app_path("Models/{$mysqlname}.php");
                    $delmodel = @unlink($model);
                    if ($delmodel){
//                        echo $model;
                        $this->info('Model deletion succeeded!');
                    }else{
//                        echo $model;
                        $this->error('Model deletion failed. Please manually confirm if there is any residue!');
                    }
                    $routes = base_path("routes/{$mysqlname}.php");
                    $routes = @unlink($routes);
//                    $routes = 1;
                    if ($routes){
//                        echo $routes;
                        $this->info('routes deletion succeeded!');
                    }else{
//                        echo $routes;
                        $this->error('routes deletion failed. Please manually confirm if there is any residue!');
                    }
                    //删除数据库中的路由
                    $this->delroute($mysqlname,$Controllername);
                }else{
                    $this->error('exit successfully!');
                }
            }else{
                //测试区
                //创建路由
                $this->routes($mysqlname,$dmysqlname,$Controllername,$N);
                //创建控制器
                $this->controllers($Controllername,$mysqlname,$field);
                //创建模型
                $this->models($pathsys,$mysqlname,$field);
                //创建视图
                $this->views($pathsys,$mysqlname,$field,$N);
            }
            system("php artisan route:clear");
        }else{
            echo "\n \n";
            $this->error( "Please check if your database name is correct!");
        }
    }
    //PHP stdClass Object转array
    protected function object_array($array) {
        if(is_object($array)) {
            $array = (array)$array;
        } if(is_array($array)) {
            foreach($array as $key=>$value) {
                $array[$key] = $this->object_array($value);
            }
        }
        return $array;
    }
    /**
     * 追加创建路由文件
     * @param $mysqlname
     * @param $dmysqlname
     * @param $pathsys
     * Date: 2018/11/23 0023
     * Time: 上午 10:48
     */
    protected function routes($mysqlname,$dmysqlname,$Controllername,$N){
        $routes = app_path('Console/template/Controller/routes.php');//路由原文件
        $path = base_path('routes/'.$mysqlname.'.php');//路由新文件
        $replace = $this->modelreplace($routes,$path,'tag',$mysqlname);
        $replace = $this->modelreplace($routes,$path,'Tag',$dmysqlname);
        if ($replace){
            //在这里分 主路径和子路径
            if (strpos($Controllername,'/')){
                $adminname = substr($Controllername,0,strpos($Controllername,'/'));
            }else{
                $adminname = $mysqlname;
            }
            //如果没有指定菜单名称，菜单就是数据库表名称
            if (empty($N)){
                $N = $mysqlname;
            }
            $this->routefile($mysqlname);
            $this->modelreplace($routes,$path,'kang',$mysqlname);
            $Maindata = [
                'name' => $mysqlname.'.manage',//别名
                'guard_name' => 'web',//路由类型
                'display_name' => $N,//菜单名称
                'route' => '',//控制器地址
                'created_at' => date('Y-m-d H:i:s',time()),
            ];
            $per = DB::table('permissions')
                ->where('name',$mysqlname.'.manage')
                ->first();
            if (empty($per)){
                //创建第一个菜单
                $create = Permission::create($Maindata);
                $per_id = $create->id;
            }else{
                $per_id = $per->id;
                $permission = Permission::findOrFail($per_id);
                $permission->update($Maindata);
            }
            //分配权限
            $has_permissions = [
                'permission_id' => $per_id,
                'role_id' => '6',
            ];
            DB::table('role_has_permissions')->insert($has_permissions);
            //创建子菜单
            $add = 'admin.'.$mysqlname.'.create'; //创建
            $edit = 'admin.'.$mysqlname.'.edit'; //编辑更新
            $destroy = 'admin.'.$mysqlname.'.destroy'; //删除
            $cdarray = [$add,$edit,$destroy];
            $minorder = DB::table('permissions')
                ->whereIn('route',$cdarray)
                ->first();
            if (empty($minorder)){
                //增加子菜单
                $Maindata = [
                    'guard_name' => 'web',//路由类型
                    'display_name' => $N,//菜单名称
                    'parent_id' => $per_id, //上级ID
                    'created_at' => date('Y-m-d H:i:s',time()),
                ];
                $Maindata['route'] = 'admin.'.$mysqlname;
                $Maindata['display_name'] = $N.'管理'; //菜单名称
                $Maindata['name'] = 'cruds.'.$mysqlname;
                $createroute = Permission::create($Maindata);
                $permissions_id = $createroute->id;

                //分配权限
                $has_permissions = [
                    'permission_id' => $permissions_id,
                    'role_id' => '6',
                ];
                DB::table('role_has_permissions')->insert($has_permissions);

                $Maindata['parent_id'] = $permissions_id; //再增下级菜单
                foreach ($cdarray as $route){
                    $Maindata['route'] = $route;
                    if (strpos($route,'create')){
                        $Maindata['display_name'] = '创建'.$N; //菜单名称
                        $Maindata['name'] = 'cruds.'.$mysqlname.'.create';
                    }elseif (strpos($route,'edit')){
                        $Maindata['display_name'] = '编辑'.$N; //菜单名称
                        $Maindata['name'] = 'cruds.'.$mysqlname.'.edit';
                    }elseif (strpos($route,'destroy')){
                        $Maindata['display_name'] = '删除'.$N; //菜单名称
                        $Maindata['name'] = 'cruds.'.$mysqlname.'.destroy';
                    }
                    $perzid = DB::table('permissions')->insertGetid($Maindata);
                    //分配权限
                    $has_permissions = [
                        'permission_id' => $perzid,
                        'role_id' => '6',
                    ];
                    DB::table('role_has_permissions')->insert($has_permissions);
                }

            }
            echo 'Route ok'."\n\n";
        }else{
            echo 'A write error has occurred !';
        }
    }

    /**
     * 追加路由
     * @param $mysqlname
     * @param $dmysqlname
     * Date: 2018/11/26 0026
     * Time: 下午 9:32
     */
    protected function routefile($mysqlname){
        $routeurl = base_path('app\Providers\RouteServiceProvider.php');
        $funname = '$this->'.$mysqlname.'Routes();';
        $funnamecontent = <<<EOF
        \n
        //---$mysqlname---start
        $funname
        //---$mysqlname---stop
EOF;
        $target = 'this_routing';
        $fileConts = file_get_contents($routeurl);
        $content = strpos($fileConts, $mysqlname);
        var_dump($content);
        if (empty($content)){
            $this->insertAfterTarget($routeurl,$funnamecontent,$target);
            $insertCont = $this->routefilecontent($mysqlname);
            $tag = 'More_routing_files';
            $this->insertAfterTarget($routeurl,$insertCont,$tag);
        }
    }

    /**
     * 删除内容所在的某一行
     * @param $filePath
     * @param $target
     * Date: 2018/11/26 0026
     * Time: 下午 10:53
     */
    protected function delTargetLine($mysqlname,$target,$targets)
    {
        $filePath = base_path('app\Providers\RouteServiceProvider.php');
        $result = null;
        $fileCont = file_get_contents($filePath);
        $targetIndex = strpos($fileCont, $target); #查找目标字符串的坐标
        if ($targetIndex !== false) {
            #找到target的前一个换行符
            $preChLineIndex = $targetIndex;
            #找到target的后一个换行符
            $AfterChLineIndex = strpos($fileCont, $targets);
            if ($preChLineIndex !== false && $AfterChLineIndex !== false) {
                #重新写入删掉指定行后的内容
                $result = substr($fileCont, 0, $preChLineIndex) . substr($fileCont, $AfterChLineIndex+18);
                $fp = fopen($filePath, "w+");
                fwrite($fp, $result);
                fclose($fp);
            }
        }
    }
    /**
     * 在需要查找的内容后一行新起一行插入内容
     * @param $filePath 文件路径
     * @param $insertCont 插入的内容
     * @param $target 查找的字符串
     * Date: 2018/11/26 0026
     * Time: 下午 9:55
     */
    protected function insertAfterTarget($filePath, $insertCont, $target)
    {
        $result = null;
        $fileCont = file_get_contents($filePath);
        $targetIndex = strpos($fileCont, $target); #查找目标字符串的坐标
        if ($targetIndex !== false) {
            #找到More_routing_files的后一个换行符
            $chLineIndex = strpos(substr($fileCont, $targetIndex), "\n") + $targetIndex;
            if ($chLineIndex !== false) {
                #插入需要插入的内容
                $result = substr($fileCont, 0, $chLineIndex + 1) . $insertCont . "\n" . substr($fileCont, $chLineIndex + 1);
                $fp = fopen($filePath, "w+");
                fwrite($fp, $result);
                fclose($fp);
            }
        }
    }
    /**
     * 删除数据库中的路由记录
     * @param $mysqlname
     * Date: 2018/11/26 0026
     * Time: 下午 2:10
     */
    protected function delroute($mysqlname,$Controllername){
        //在这里分 主路径和子路径，操作删除时要小心，此处未完全写通顺
        //以防万一，主路径 暂不删除
        if (strpos($Controllername,'/')){
            $adminname = substr($Controllername,0,strpos($Controllername,'/'));
        }else{
            $adminname = $mysqlname;
        }
        //////////
        $name = $mysqlname.'.manage';
        $per = DB::table('permissions')
            ->where('name',$name)
            ->first();
        if (!empty($per)){
            //删除子菜单
            $dn = $mysqlname.'.manage';
            $dns = 'cruds.'.$mysqlname;
            $gl = 'admin.'.$mysqlname;//管理
            $add = 'admin.'.$mysqlname.'.create'; //创建
            $edit = 'admin.'.$mysqlname.'.edit'; //编辑更新
            $destroy = 'admin.'.$mysqlname.'.destroy'; //删除
            $cdarray = [$gl,$add,$edit,$destroy,$dn,$dns];
            foreach ($cdarray as $route){
                //获得菜单权限ID
                $permissions_id = DB::table('permissions')
                    ->where('route',$route)
                    ->orWhere('name',$route)
                    ->value('id');
                $this->delrou($permissions_id);
                //删除分配权限
                DB::table('role_has_permissions')
                    ->where('permission_id',$permissions_id)
                    ->delete();
                //删除权限菜单
                DB::table('permissions')
                    ->where('route',$route)
                    ->delete();
            }
            //再次确认删除事项
            DB::table('permissions')
                ->whereIn('route',$cdarray)
                ->delete();
        }
    }

    /**
     * 删除权限
     * @param $permissions_id
     *
     * @return \Illuminate\Http\JsonResponse
     * Date: 2018/11/26 0026
     * Time: 下午 8:42
     */
    protected function delrou($permissions_id = 0){
        if (empty($permissions_id)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        $permission = Permission::find($permissions_id);
        if (!$permission){
            return response()->json(['code'=>-1,'msg'=>'权限不存在']);
        }
        //如果有子权限，则禁止删除
        if (Permission::where('parent_id',$permissions_id)->first()){
            return response()->json(['code'=>2,'msg'=>'存在子权限禁止删除']);
        }

        if ($permission->delete()){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
    }
    /**
     * 创建控制器文件
     * @param $pathsys 视图文件路径
     * @param $mysqlname 数据库表名称
     * @param $field 数据库表字段 属性 描述
     * Date: 2018/11/22 0022
     * Time: 下午 10:23
     */
    public function controllers($pathsys,$mysqlname,$field){
        $controllers = app_path('Console/template/Controller/CrudsController.php');//控制器原文件
        $dmysqlname = ucfirst(strtolower($mysqlname));
        $dConname = ucfirst(strtolower($mysqlname)).'Controller';
//        echo $pathsys;die; admin/appealController
        $path = app_path('Http/Controllers/'.$pathsys.'.php');//控制器新文件
        $array = [];
        $validate = [];
        $controsofield = [];
        $controsoiffield = [];
        foreach ($field as $key=>$value){
            $array[] = '\''.$value['field'].'\'';
            $check = $value['check'];
            $field = $value['field'];
            if ($check == 'YES'){
                $fieldtype = $value['fieldtype'];
                $strcz = strpos($fieldtype,'(');
                if (!empty($strcz)){
                    $fieldtype = substr($fieldtype,0,$strcz);
                }
                if ($fieldtype == 'varchar'){
                    $validate[] = '\''.$value['field'].'\' => \'required|string\'';
                }
                if ($fieldtype == 'int'){
                    $validate[] = '\''.$value['field'].'\' => \'required|numeric\'';
                }
            }
            if (!empty(strpos($field,'_s'))){
                $controsofield[] = "'$field'";
                $sofield = "'$field'";
                $controsoiffield[] = 'if (!empty($res['.$sofield.'])){
                $model = Tag::where('.$sofield.',\'like\',\'%\'.$res['.$sofield.'].\'%\');
            }';
            }
        }

        //循环结束
        if (empty($validate)){
            $strvalidate = '[]';
        }else{
            $validate = implode(',',$validate);
            $strvalidate = '['.$validate.']';
        }
        if (empty($array)){
            $strarray = [];
        }else{
            array_shift($array);
            $array = implode(',',$array);
            $strarray = '['.$array.']';
        }

        $this->modelreplace($controllers,$path,'tag',$mysqlname);

        if (empty($controsofield)){
            $controsofield = '';
        }else{
            $controsofield = implode("\n\n",$controsofield);
        }
        $this->modelreplace($controllers,$path,'controsofield',$controsofield);

        if (empty($controsoiffield)){
            $controsoiffield = '';
        }else{
            $controsoiffield = implode("\n\n",$controsoiffield);
        }
        $this->modelreplace($controllers,$path,'controsoiffield;',$controsoiffield);

        $replace = $this->modelreplace($controllers,$path,'strvalidate',$strvalidate);
        $replace = $this->modelreplace($controllers,$path,'retasl',$dConname);
        $replace = $this->modelreplace($controllers,$path,'Tag',$dmysqlname);
        $replace = $this->modelreplace($controllers,$path,'fieldarray',$strarray);
        if ($replace){
            echo 'Controllers ok'."\n\n";
        }else{
            echo 'A write error has occurred !';
        }
    }

    /**
     * 创建模型文件
     * @param $pathsys
     * @param $mysqlname
     * @param $field
     * Date: 2018/11/22 0022
     * Time: 下午 10:24
     */
    public function models($pathsys,$mysqlname,$field){
        $model = app_path('Console/template/Models/Cruds.php');//模型原文件
        $dmysqlname = ucfirst(strtolower($mysqlname));
        $path = app_path('Models/'.$dmysqlname.'.php');//模型文件
        $array = [];
        foreach ($field as $key=>$value){
            $array[] = '\''.$value['field'].'\'';
        }
        $array = implode(',',$array);
        $strarray = '['.$array.']';
        if (strpos($strarray,'updated_at')){
            $this->modelreplace($model,$path,'false',true);
        }
        $replace = $this->modelreplace($model,$path,'tag',$mysqlname);
        $replace = $this->modelreplace($model,$path,'retasl',$dmysqlname);
        $replace = $this->modelreplace($model,$path,'fieldarray',$strarray);
        if ($replace){
            echo 'model ok'."\n\n";
        }else{
            echo 'A write error has occurred !';
        }
    }
    /**
     * 创建视图文件
     * @param $pathsys 需要复制的视图路径
     * @param $mysqlname 数据库名称
     * @param $field 字段名称、字段类型，字段描述
     * Date: 2018/11/22 0022
     * Time: 下午 8:18
     */
    public function views($pathsys,$mysqlname,$field,$N){
        //需要复制的文件有：
        $mainfile = app_path('Console/template/Views/index.blade.php');//管理文件
        $form = app_path('Console/template/Views/_form.blade.php');//表单文件
        $formjs = app_path('Console/template/Views/_js.blade.php');//表单文件
        $create = app_path('Console/template/Views/create.blade.php');//创建添加页面
        $edit = app_path('Console/template/Views/edit.blade.php');//编辑更新页面
        //需要做的事情有：
        //文件读取、替换与复制写入内容
        $index = $pathsys.'/index.blade.php';
        $forms = $pathsys.'/_form.blade.php';
        $formsjs = $pathsys.'/_js.blade.php';
        $creates = $pathsys.'/create.blade.php';
        $edits = $pathsys.'/edit.blade.php';

        $file = [$mainfile,$form,$formjs,$create,$edit];//元路径
        $path = [$index,$forms,$formsjs,$creates,$edits];//新路径

        $countnum = count($file);
        for ($i=0;$i<$countnum;$i++){
            $replace = $this->replacecontent($file[$i],$path[$i],'tag',$mysqlname);
            if ($replace){
                echo 'View ok'."\n\n";
            }else{
                echo 'A write error has occurred !';
            }
        }
        $this->Viewsindex($index,$mysqlname,$field);
        $this->Viewsform($forms,$mysqlname,$field);
        $this->viewsedit($N,$edits);
        $this->viewscreate($N,$creates);
        $this->Viewsformjs($formsjs,$mysqlname,$field);
    }

    /**
     * 视图编辑更新
     * @param $mysqlname
     * Date: 2018/11/27 0027
     * Time: 上午 9:23
     */
    protected function viewsedit($mysqlname,$edits){
        $edit = app_path('Console/template/Views/edit.blade.php');
        $addcontent = '编辑'.$mysqlname;
        $this->modelreplace($edit,$edits,'editcont',$addcontent);
    }

    /**
     * 视图创建添加
     * @param $mysqlname
     * Date: 2018/11/27 0027
     * Time: 上午 9:22
     */
    protected function viewscreate($mysqlname,$creates){
        $create = app_path('Console/template/Views/create.blade.php');
        $addcontent = '添加'.$mysqlname;
        $this->modelreplace($create,$creates,'addcontent',$addcontent);
    }

    /**
     * 管理页面
     * @param $index
     * @param $mysqlname
     * @param $field
     * Date: 2018/11/23 0023
     * Time: 上午 9:27
     */
    protected function Viewsindex($index,$mysqlname,$field){
        $array = [];
        $img = [];
        $so = [];
        $sojs = [];
        $sowhere = [];
        $somark = '';
        foreach ($field as $key=>$value){
            $field = $value['field'];
            $fielddec = $value['fielddec'];
            if (empty($value['fielddec'])){
                $array[] = "{field: '".$value['field']."', title: '".$value['field']."', sort: true}";
            }elseif (strpos($value['field'],'image') != false || strpos($value['field'],'img') != false || $value['field'] == 'image' || $value['field'] == 'images'){
                $array[] = "{field: '".$value['field']."', title: '".$value['fielddec']."',toolbar:'#".$value['field']."',width:100}";
                $img[] = <<<EOF
<script type="text/html" id="$field">
                <a href="@{{d.$field}}" target="_blank" title="点击查看"><img src="@{{d.$field}}" alt="" width="28" height="28"></a>
            </script>
EOF;
            }else{
                $array[] = "{field: '".$value['field']."', title: '".$value['fielddec']."', sort: true}";
            }
            $ss = strpos($value['field'],'_s');
            if (!empty($ss)){
                $somark = '<button type="button" class="layui-btn layui-btn-sm" id="searchBtn">搜索</button>';
                $so[] = <<<EOF
                    
            <div class="layui-input-inline">
                        <input type="text" name="$field" id="$field" placeholder="请输入$fielddec" class="layui-input" >
            </div>
EOF;
                $sojs[] = "var $field = $(\"#$field\").val()";
                $sowhere[] = "$field:$field";
            }
        }
        $sowhere = implode(',',$sowhere);
        $this->modelreplace($index,$index,'fieldsowhere',$sowhere);

        $img = implode("\n\n",$img);
        $this->modelreplace($index,$index,'fieldimgjs',$img);

        $sojs = implode("\n\n",$sojs);
        $this->modelreplace($index,$index,'fieldsojs',$sojs);

        $this->modelreplace($index,$index,'somark',$somark);
        $so = implode("\n\n",$so);
        $this->modelreplace($index,$index,'fieldsodata',$so);
        $array = implode(',',$array);
        $strarray = ','.$array;
        $this->modelreplace($index,$index,'fieldnames',$strarray);
    }

    /**
     * 视图表单页面
     * @param $index
     * @param $mysqlname
     * @param $field
     * Date: 2018/11/23 0023
     * Time: 上午 10:09
     */
    protected function Viewsform($index,$mysqlname,$field){
        $array = [];
        foreach ($field as $key=>$value){
            $fielddec = $value['fielddec'];
            $field = $value['field'];
            $fieldtype = $value['fieldtype'];
            $strcz = strpos($fieldtype,'(');
            if (!empty($strcz)){
                $fieldtype = substr($fieldtype,0,$strcz);
            }
            if (empty($value['fielddec'])){
                $array[] = '<div class="layui-form-item"><label for="" class="layui-form-label">'.$value["field"].'</label><div class="layui-input-block"><input type="text" name="'.$value["field"].'" value="{{ $'.$mysqlname.'->'.$value["field"].' ?? old(\''.$value["field"].'\') }}" lay-verify="required" placeholder="请输入'.$value["field"].'" class="layui-input" ></div></div>';
            }
            elseif (strpos($value['field'],'date') || strpos($value['field'],'time') || strpos($value['field'],'update_at')){
                $str = '$'.$mysqlname.'->'.$value['field'];
                $values = "{{date('Y-m-d H:i:s',$str??time())}}";
                $fieldid = $field.'Time';
                $array[] = <<<EOF
<div class="layui-form-item">
    <label for="" class="layui-form-label">$fielddec</label>
    <div class="layui-input-block">
        <input type="text" class="layui-input" value="$values" name="$field" id="$fieldid">
    </div>
</div>
EOF;

            }
            elseif (strpos($value['field'],'image') || strpos($value['field'],'img') || strpos($value['field'],'avatar')  || $value['field'] == 'image' || $value['field'] == 'img'){
                $values = "$".$mysqlname."->".$value['field'];
                $uploadPic = $field.'Pic';
                $array[] = <<<EOF
<div class="layui-form-item">
    <label for="" class="layui-form-label">$fielddec</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="$uploadPic"><i class="layui-icon">&#xe67c;</i>文件上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($values))
                        <li><img src="{{ $values }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="$field" id="$field" value="{{ $values ?? '' }}">
            </div>
        </div>
    </div>
</div>
EOF;

            }elseif ($fieldtype == 'TEXT' || $fieldtype == 'text' || strpos($field,'content') != false){
                $jz = '$'.$mysqlname.'->'.$field;
                $array[] = <<<EOF
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">$fielddec</label>
                    <div class="layui-input-block">
                        <textarea name="$field" class="layui-textarea" cols="30" rows="6" lay-verify="required" placeholder="请输入$fielddec">{{ $jz ?? old('$field')}}</textarea>
                    </div>
                </div>
EOF;
            }else{
                $array[] = '<div class="layui-form-item"><label for="" class="layui-form-label">'.$value["fielddec"].'</label><div class="layui-input-block"><input type="text" name="'.$value["field"].'" value="{{ $'.$mysqlname.'->'.$value["field"].' ?? old(\''.$value["field"].'\') }}" lay-verify="required" placeholder="请输入'.$value["fielddec"].'" class="layui-input" ></div></div>';
            }
        }
        array_shift($array);
        $array = implode("\n\n",$array);
        $this->modelreplace($index,$index,'formfield',$array);
    }

    /**
     * 生成相关JS
     * @param $index
     * @param $mysqlname
     * @param $field
     * Date: 2018/11/27 0027
     * Time: 下午 2:32
     */
    protected function Viewsformjs($formsjs,$mysqlname,$field){
        $array = [];
        foreach ($field as $key=>$value) {
            $fielddec = $value['fielddec'];
            $field = $value['field'];
            $uploadPic = '#'.$field.'Pic';
            $fieldJ = '#'.$value['field'];
            if (strpos($value['field'],'image') || strpos($value['field'],'img') || strpos($value['field'],'avatar')  || $value['field'] == 'image' || $value['field'] == 'img'){
                $array[] = <<<EOF
layui.use(['upload'],function () {
        var upload = layui.upload
        //普通图片上传
        var uploadInst = upload.render({
            elem: "$uploadPic"
            ,url: '{{ route("uploadImg") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                obj.preview(function(index, file, result){
                    $('#layui-upload-box').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });
            }
            ,done: function(res){
                //如果上传失败
                if(res.code == 0){
                    $("$fieldJ").val(res.url);
                    $('#layui-upload-box li p').text('上传成功');
                    return layer.msg(res.msg);
                }
                return layer.msg(res.msg);
            }
        });
    });
EOF;
            }
            if (strpos($value['field'],'date') || strpos($value['field'],'time') || strpos($value['field'],'update_at')){
                $fieldid = '#'.$field.'Time';
                $array[] = <<<EOF
layui.use('laydate', function(){
        var laydate = layui.laydate;
        //执行一个laydate实例
        laydate.render({
            elem: "$fieldid" //指定元素
            ,type: 'datetime'
        });
    });
EOF;

            }
        }
        $array = implode("\n\n",$array);
        $this->modelreplace($formsjs,$formsjs,'jsblade',$array);
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

    /**
     * 替换写入保存内容文件
     * @param $file_name 原文件
     * @param $fwritefile 替换后的文件
     * @param $tag 需要替换的内容
     * @param $mysqlname 替换后的内容
     * Date: 2018/11/22 0022
     * Time: 下午 9:41
     */
    protected function replacecontent($file_name,$fwritefile,$tag,$mysqlname){
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
            $Mytablename = ucfirst(strtolower($mysqlname));//将表名首字母转为大写
            $buffer = str_replace($tag,$Mytablename,$buffer);//替换
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

    /**
     * 需要写入的文件
     * @param $mysqlname
     *
     * @return string
     * Date: 2018/11/26 0026
     * Time: 下午 10:17
     */
    protected function routefilecontent($mysqlname){
        $funname = $mysqlname.'Routes';
        $s = "//-$mysqlname-start";
        $d = "//-$mysqlname-stop";
        return <<<EOF
    \n
    $s
    protected function $funname()
    {
        Route::middleware('web')
            ->namespace("App\Http\Controllers")
            ->group(base_path('routes/$mysqlname.php'));
    }
    $d
EOF;
    }

}
