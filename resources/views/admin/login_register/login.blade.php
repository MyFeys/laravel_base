
@extends('admin.login_register.base')

@section('content')
    <div class="sub-main-w3">
        <form action="{{route('admin.login')}}" method="post">
            {{csrf_field()}}

            <div class="form-style-agile">
                <label>
                    <i class="layui-icon layui-icon-username"></i>
                    Username
                </label>
                <input name="username" value="{{old('username')}}" lay-verify="required" placeholder="用户名" type="text" required="">
            </div>
            <div class="form-style-agile">
                <label>
                    <i class="layui-icon layui-icon-password"></i>
                    Password
                </label>
                <input name="password"  lay-verify="required" placeholder="密码" type="password" required="">
            </div>
            <!-- checkbox -->
            <div class="wthree-text">
                <ul>
                    <li>
                        <label class="anim">
                            <input type="checkbox" class="checkbox">
                            <span>记住登录</span>
                        </label>
                    </li>
                    <li>
                        <a href="#">忘记密码?</a>
                    </li>
                </ul>
            </div>
            <!-- //checkbox -->
            <input type="submit" value=" 登 录 ">
        </form>
    </div>
@endsection