<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{site("title")}}</title>
    <script type="text/javascript">
        document.documentElement.style.fontSize=document.documentElement.clientWidth/7.5+'px';
    </script>
    <meta content="width=device-width,user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{asset("public/home/css/mobile.css")}}">
    <link rel="stylesheet" href="{{asset("public/static/admin/layuiadmin/layui/css/layui.css")}}" media="all">
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

<div class="header">
    <ul>
        <li>
            <a href="/" class="active">首页</a>
        </li>
        <li>
            <a href="/list/1">操作信息</a>
        </li>
        <li>
            <a href="/list/2">操作收益</a>
        </li>
        <li>
            <a href="/list/3">股票池</a>
        </li>
        <li>
            <a href="/list/4">个股分析</a>
        </li>
    </ul>
</div>

<div class="banner">
    <img src="{{asset("public/home/images/950.png")}}" alt="">
</div>

<div class="headernav">
    <ul>
        <li>
            <a href="/list/5">经验分享</a>
        </li>
        <li>
            <a href="/pages/2">业务开展</a>
        </li>
        <li>
            <a href="/pages/3">活动</a>
        </li>
        <li>
            <a href="/pages/4">免责声明</a>
        </li>
        <li>
            <a href="/pages/1">关于我们</a>
        </li>
    </ul>
</div>
@yield('content')
<div class="mzsm">免责声明：投资有风险，请谨慎再谨慎！<br>本工作室不承担任何投资风险责任</div>
<div class="btn_h"></div>
<div class="btn">
    <p class="gp">
        <a href="/list/1">操作信息</a>
    </p>
    <p class="fx">
        <a href="/list/2">操作收益</a>
    </p>
    <p class="jy">
        <a href="/list/5">经验分享</a>
    </p>
</div>
</body>
</html>

