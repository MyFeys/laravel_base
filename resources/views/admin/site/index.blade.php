@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>站点配置</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.site.update')}}" method="post">
                {{csrf_field()}}
                {{method_field('put')}}
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">站点标题</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" value="{{ $config['title']??'' }}" lay-verify="required" placeholder="请输入标题" class="layui-input" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">站点关键词</label>
                    <div class="layui-input-block">
                        <input type="text" name="keywords" value="{{ $config['keywords']??'' }}" lay-verify="required" placeholder="请输入关键词" class="layui-input" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">站点描述</label>
                    <div class="layui-input-block">
                        <textarea class="layui-textarea" name="description" cols="30" rows="10">{{ $config['description']??'' }}</textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">首页联系我</label>
                    <div class="layui-input-block">
                        <textarea class="layui-textarea" name="lxwm" cols="30" rows="10">{{ $config['lxwm']??'' }}</textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">版权信息</label>
                    <div class="layui-input-block">
                        <textarea class="layui-textarea" name="copyright" cols="30" rows="5">{{ $config['copyright']??'' }}</textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">咨询热线</label>
                    <div class="layui-input-block">
                        <input type="text" name="phone" value="{{ $config['phone']??'' }}" lay-verify="required" placeholder="请输入电话" class="layui-input" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">单位名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="unitname" value="{{ $config['unitname']??'' }}" lay-verify="required" placeholder="请输入单位名称" class="layui-input" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection