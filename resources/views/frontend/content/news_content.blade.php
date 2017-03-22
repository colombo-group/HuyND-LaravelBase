@extends('frontend.layout')
@section('front_content')
<div class="row">
    <div class="title">{{ $content->title }}</div>
    <div class="row">
        <div class="col-md-3 left-news">
            <div class="col-md-12 img">
                <img src="{{ asset('upload/news/'.$content->img) }}">
            </div>
            <div class="col-md-12 create">
                <div class="col-md-12">
                    Created at: {{ $content->created_at!=null?$content->created_at:'' }}
                </div>
                @if($content->updated_at!=null)
                <div class="col-md-12 create">
                   Updated at: {{ $content->updated_at }}
                </div>
                @endif
            </div>
        </div>
        <div class="col-md-9 content">
            {{ $content->content }}

        </div>
    </div>
</div>
@endsection