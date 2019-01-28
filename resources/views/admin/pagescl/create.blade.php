@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加单页栏目</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.pagescl.store')}}" method="post">
                @include('admin.pagescl._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.pagescl._js')
@endsection