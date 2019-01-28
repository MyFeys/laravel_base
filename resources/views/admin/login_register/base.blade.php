<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>管理员后台登录</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="{{URL::asset("public/static/admin/layuiadmin/layui/css/layui.css")}}" media="all">
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <link rel="stylesheet" href="{{URL::asset('public/static/admin/login/style.css')}}" type="text/css" media="all" />
    <!-- Style-CSS -->
    <link rel="stylesheet" href="{{asset("public/static/admin/login/fontawesome-all.css")}}">

</head>
<body>
<div id="bg">
    <canvas></canvas>
    <canvas></canvas>
    <canvas></canvas>
</div>
<h1>后台管理系统</h1>
@yield('content')
<div class="footer">
    <p>Copyright &copy; 2018.admin All rights reserved.</p>
</div>

<script src="{{asset("public/static/admin/layuiadmin/layui/layui.js")}}"></script>
<script>
    layui.config({
        base: '/public/static/admin/layuiadmin/' //静态资源所在路径
    }).use(['layer'],function () {
        var layer = layui.layer;
        //表单提示信息
        @if(count($errors)>0)
            @foreach($errors->all() as $error)
                layer.msg("{{$error}}",{icon:5});
                @break
            @endforeach
        @endif
        //正确提示
        @if(session('success'))
        layer.msg("{{session('success')}}",{icon:6});
        @endif

    })
</script>

<script src="{{asset("public/static/admin/login/jquery-3.3.1.min.js")}}"></script>
<!-- effect js -->
<script src="{{asset("public/static/admin/login/canva_moving_effect.js")}}"></script>
</body>
</html>