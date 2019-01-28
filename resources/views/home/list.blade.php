@extends('home.base')
@section('content')

    <div class="layui-fluid">
        <fieldset class="layui-elem-field layui-field-title">
            <legend><b>{{$classname}}</b></legend>
        </fieldset>

        <div class="whitebg bloglist">
            <ul>
                @foreach ($lists as $list)
                <li>
                    <h3 class="blogtitle">
                        <a href="/info/{{$list->id}}" target="_blank">{{ $list->title }}</a>
                    </h3>
              {{--      <span class="blogpic imgscale">
                        <a href="/info/{{$list->id}}" title="{{ $list->title }}">
                            <img src="{{articles_img(1)->thumb ?? asset("public/home/images/pcnone.png")}}" alt="{{ $list->title }}">
                        </a>
                    </span>--}}
                    <p class="blogtext">信息描述：{{ $list->description }} </p>
                    <p class="bloginfo">
                        <span></span>
                        <span>{{$list->click}}人已围观</span>
                        <span>发布时间：{{date('Y-m-d',strtotime($list->created_at))}}</span>
                        @if(!empty($infos->keywords))
                            <span>【<a href="/info/{{$list->id}}" target="_blank">{{$list->keywords}}</a>】
                        </span>
                        @endif
                    </p>
                    <a href="/info/{{$list->id}}" class="viewmore">阅读更多</a>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="layui-row">
            {{ $lists->links() }}
        </div>
    </div>



@endsection