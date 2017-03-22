@extends('frontend.layout')
@section('front_content')
    <div class="title">List of News</div>
    @foreach($news as $rows)
    <div class="container row news">
        <div class="col-md-3 img">
            <img src="{{ asset('upload/news/'.$rows->img) }}"'>
        </div>
        <div class="col-md-9 box">
            <div class="col-md-12 news-title">
                <a href="{{ url(route('news_content',$rows->id)) }}">{{ $rows->title }}</a>
            </div>
            <div class="col-md-12 news-content">
                {{ substr($rows->content,0,100).'...' }}
            </div>
        </div>
    </div>
    @endforeach
@endsection