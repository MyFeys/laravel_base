@extends('home.base')
@section('content')
    <div class="main_center">
        <div class="section_top">
            <div class="contact_us">
                <div class="contact_us_top">
                    <div class="title">
                        <span class="line"></span>
                        <span class="tit">联系我</span>
                    </div>
                    <div class="contact_us_detail">
                        <pre class="pre">{{site("lxwm")}}</pre>
                    </div>
                </div>
                <div class="contact_more">
                    <div class="contact_more_top">
                        <a href="/pages/1">
                        <div class="about_us">
                            <span><img src="{{asset("public/home/images/about.png")}}" alt="">关于我们</span>
                        </div>
                        </a>
                        <a href="/pages/2">
                        <div class="kaizhan">
                            <span><img src="{{asset("public/home/images/ywkz.png")}}" alt="">业务开展</span>
                        </div>
                        </a>
                    </div>
                    <div class="contact_more_top">
                        <a href="/pages/3">
                        <div class="about_us">
                            <span><img src="{{asset("public/home/images/hd.png")}}"  alt="">活动</span>
                        </div>
                        </a>
                        <a href="/pages/4">
                        <div class="kaizhan">
                            <span><img src="{{asset("public/home/images/fa.png")}}"  alt="">免责说明</span>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="list_box">
                <div class="title">
                    <span class="line"></span>
                    <span class="tit">操作信息</span>
                    <span class="more"><a href="list/1" target="_blank">MORE</a></span>
                </div>
                <ul>
                    @foreach(articles(1,6) as $key=>$list)
                    <li>
                        <a href="info/{{$list->id}}">
                            <img src="{{asset("public/home/images/jt.png")}}" alt="">
                            {{$list->title}}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="list_box">
                <div class="title">
                    <span class="line"></span>
                    <span class="tit">操作收益</span>
                    <span class="more"><a href="list/2" target="_blank">MORE</a></span>
                </div>
                <ul>
                    @foreach(articles(2,6) as $key=>$list)
                        <li>
                            <a href="info/{{$list->id}}">
                                <img src="{{asset("public/home/images/jt.png")}}" alt="">
                                {{$list->title}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="advert">
                @foreach($advert as $key => $list)
                <img src="{{$list->thumb}}" alt="{{$list->title}}">
                @endforeach
        </div>
        <div class="section_top">
            <div class="list_box" style="margin: 0">
                <div class="title">
                    <span class="line"></span>
                    <span class="tit">股票池</span>
                    <span class="more"><a href="list/3" target="_blank">MORE</a></span>
                </div>
                <ul>
                    @foreach(articles(3,6) as $key=>$list)
                        <li>
                            <a href="info/{{$list->id}}">
                                <img src="{{asset("public/home/images/jt.png")}}" alt="">
                                {{$list->title}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="list_box">
                <div class="title">
                    <span class="line"></span>
                    <span class="tit">个股分析</span>
                    <span class="more"><a href="list/4" target="_blank">MORE</a></span>
                </div>
                <ul>
                    @foreach(articles(4,6) as $key=>$list)
                        <li>
                            <a href="info/{{$list->id}}">
                                <img src="{{asset("public/home/images/jt.png")}}" alt="">
                                {{$list->title}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="list_box">
                <div class="title">
                    <span class="line"></span>
                    <span class="tit">经验分享</span>
                    <span class="more"><a href="list/5" target="_blank">MORE</a></span>
                </div>
                <ul>
                    @foreach(articles(5,6) as $key=>$list)
                        <li>
                            <a href="info/{{$list->id}}">
                                <img src="{{asset("public/home/images/jt.png")}}" alt="">
                                {{$list->title}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection