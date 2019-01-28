@extends('mobile.base')
@section('content')
    <div class="content_box whitebg">
        <h2 class="htitle"><span class="con_nav">您现在的位置是：<a href="/">首页</a>&nbsp;&gt;&nbsp;<a href="/list/{{$classname->id}}">{{$classname->name}}</a></span>{{$classname->name}}</h2>
        <h1 class="con_tilte">{{ $infos->title }}</h1>
        <p class="bloginfo">
            <span></span>
            <span>{{$infos->updated_at}}</span>
            @if(!empty($infos->keywords))
            <span>【{{$infos->keywords}}】</span>
            @endif
            <span>{{ $infos->click }}人已围观</span></p>
        @if(!empty($infos->description))
        <p class="con_info"><b></b>描述{{ $infos->description }}</p>
        @endif
        <div class="con_text">
            {!! $infos->content !!}
            <div class="nextinfo">
                <p>上一篇：<a href="/info/{{ $previous->id }}">{{ $previous->title }}</a></p>
                <p>下一篇：<a href="/info/{{ $next_article->id }}">{{ $next_article->title }}</a></p>
            </div>
        </div>
    </div>

@endsection