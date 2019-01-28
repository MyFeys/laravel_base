@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑单页栏目</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.pagescl.update',['id'=>$pagescl->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.pagescl._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.pagescl._js')
@endsection