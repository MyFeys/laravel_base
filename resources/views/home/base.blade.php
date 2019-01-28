<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{site("title")}}</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{asset("public/home/css/index.css")}}">
    <link rel="stylesheet" href="{{asset("public/static/admin/layuiadmin/layui/css/layui.css")}}" media="all">
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="main">
    <div class="header">
        <ul>

            <li>
                <a href="/" class="active">首页</a>
            </li>
            @foreach($nav as $key=>$dh)
                <li>
                    <a href="/list/{{$dh->id}}">{{$dh->name}}</a>
                </li>
            @endforeach
            <li>
                <a href="/pages/5" class="active">联系我</a>
            </li>
        </ul>
    </div>
    <div class="banner">
        <div class="banner-img"></div>
    </div>
    <div class="w950">
    @yield('content')
    </div>
</div>
<div class="footer">
    <div class="footer_main">
        <span><pre>{{site("copyright")}}</pre></span>
        <img src="{{asset("public/home/images/logo.jpeg")}}" alt="">
    </div>
</div>
</body>
</html>


<script type="text/javascript">
    window.onload=function(){
        changeDivHeight();
    }
    //当浏览器窗口大小改变时，设置显示内容的高度
    window.onresize=function(){
        changeDivHeight();
    }
    function changeDivHeight(){
        var w = document.documentElement.clientWidth;//获取页面可见高度
        if (w < 750) {
            //    跳转到m站
        }
    }
</script>
