@extends('mobile.base')
@section('content')
    <div class="content_box whitebg">
        <h2 class="htitle"><span class="con_nav">{{ $infos->click }}人已围观 </span>{{ $infos->name }}</h2>
        <div class="con_text">
            {!! $infos->content !!}
        </div>
    </div>
@endsection