@extends('mobile.base')
@section('content')
    <div class="operation_info">
        <div class="title1">
            <span class="tit">{{$classname}}</span>
        </div>
{{--        <div class="pic_info">
            <a href="/info/{{articles_img(1)->id ?? ""}}">
                <img src="{{articles_img(1)->thumb ?? asset("public/home/images/none.png")}}" alt="">
                <p class="title">{{articles_img(1)->title ?? "暂无图片主题"}}</p>
            </a>
        </div>--}}
        <ul>
            @foreach ($lists as $list)
                <li>
                    <a href="/info/{{$list->id}}">· {{cut_str($list->title,16, 0)}}</a><span>{{date('Y-m-d',strtotime($list->created_at))}}</span>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="mzsm">
    {{ $lists->links() }}
    </div>

@endsection