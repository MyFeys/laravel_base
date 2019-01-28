@extends('mobile.base')
@section('content')
    <div class="operation_info">
        <div class="title1">
            <span class="tit">操作信息</span>
            <span class="more"><a href="list/1"> MORE</a></span>
        </div>
 {{--       <div class="pic_info">
            <a href="info/{{articles_img(1)->id ?? ""}}">
            <img src="{{articles_img(1)->thumb ?? asset("public/home/images/none.png")}}" alt="">
            <p class="title">{{articles_img(1)->title ?? "暂无图片主题"}}</p>
            </a>
        </div>--}}
        <ul>
            @foreach(articles(1,6) as $key=>$list)
            <li>
                <a href="info/{{$list->id}}">· {{cut_str($list->title,16, 0)}}</a><span>{{date('Y-m-d',strtotime($list->created_at))}}</span>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="operation_info">
        <div class="title1">
            <span class="tit">操作收益</span>
            <span class="more"><a href="list/2"> MORE</a></span>
        </div>
{{--        <div class="pic_info">
            <a href="info/{{articles_img(2)->id ?? ""}}">
                <img src="{{articles_img(2)->thumb ?? asset("public/home/images/none.png")}}" alt="">
                <p class="title">{{articles_img(2)->title ?? "暂无图片主题"}}</p>
            </a>
        </div>--}}
        <ul>
            @foreach(articles(2,6) as $key=>$list)
                <li>
                    <a href="info/{{$list->id}}">· {{cut_str($list->title,16, 0)}}</a><span>{{date('Y-m-d',strtotime($list->created_at))}}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="operation_info">
        <div class="title1">
            <span class="tit">股票池</span>
            <span class="more"><a href="list/3"> MORE</a></span>
        </div>
{{--        <div class="pic_info">
            <a href="info/{{articles_img(3)->id ?? ""}}">
                <img src="{{articles_img(3)->thumb ?? asset("public/home/images/none.png")}}" alt="">
                <p class="title">{{articles_img(3)->title ?? "暂无图片主题"}}</p>
            </a>
        </div>--}}
        <ul>
            @foreach(articles(3,6) as $key=>$list)
                <li>
                    <a href="info/{{$list->id}}">· {{cut_str($list->title,16, 0)}}</a><span>{{date('Y-m-d',strtotime($list->created_at))}}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="operation_info">
        <div class="title1">
            <span class="tit">个股分析</span>
            <span class="more"><a href="list/4"> MORE</a></span>
        </div>
    {{--    <div class="pic_info">
            <a href="info/{{articles_img(4)->id ?? ""}}">
                <img src="{{articles_img(4)->thumb ?? asset("public/home/images/none.png")}}" alt="">
                <p class="title">{{articles_img(4)->title ?? "暂无图片主题"}}</p>
            </a>
        </div>--}}
        <ul>
            @foreach(articles(4,6) as $key=>$list)
                <li>
                    <a href="info/{{$list->id}}">· {{cut_str($list->title,16, 0)}}</a><span>{{date('Y-m-d',strtotime($list->created_at))}}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="operation_info">
        <div class="title1">
            <span class="tit">经验分享</span>
            <span class="more"><a href="list/5"> MORE</a></span>
        </div>
{{--        <div class="pic_info">
            <a href="info/{{articles_img(5)->id ?? ""}}">
                <img src="{{articles_img(5)->thumb ?? asset("public/home/images/none.png")}}" alt="">
                <p class="title">{{articles_img(5)->title ?? "暂无图片主题"}}</p>
            </a>
        </div>--}}
        <ul>
            @foreach(articles(5,6) as $key=>$list)
                <li>
                    <a href="info/{{$list->id}}">· {{cut_str($list->title,16, 0)}}</a><span>{{date('Y-m-d',strtotime($list->created_at))}}</span>
                </li>
            @endforeach
        </ul>
    </div>

@endsection