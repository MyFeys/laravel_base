{{csrf_field()}}

<div class="layui-form-item"><label for="" class="layui-form-label">页面名称</label><div class="layui-input-block"><input type="text" name="name" value="{{ $pagescl->name ?? old('name') }}" lay-verify="required" placeholder="请输入页面名称" class="layui-input" ></div></div>

@include('UEditor::head');
<div class="layui-form-item">
    <label for="" class="layui-form-label">详细内容</label>
    <div class="layui-input-block">
        <script id="container" name="content" type="text/plain">
            {!! $pagescl->content??old('content') !!}
        </script>
    </div>
</div>

<div class="layui-form-item"><label for="" class="layui-form-label">排序</label><div class="layui-input-block"><input type="text" name="sort" value="{{ $pagescl->sort ?? old('sort') }}" lay-verify="required" placeholder="请输入排序" class="layui-input" ></div></div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.pagescl')}}" >返 回</a>
    </div>
</div>