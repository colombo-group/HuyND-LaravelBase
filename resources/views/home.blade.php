@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <ul class="nav navbar-nav">
                    <li><a class="navbar-brand" href="{{ url(route('edit_user',Auth::id())) }}">Hello {{ Auth::user()->name }} !!</a></li>
                    <li><a href="{{ url(route('home')) }}">Home</a></li>
                    <li><a href="{{ url(route('list_user')) }}">List user</a></li>
                    <li><a href="{{ url(route('news')) }}">List news</a></li>
                    @if(Auth::user()->id_acc==1)
                        <li><a href="{{ url(route('deleted_user')) }}">Deleted Account</a></li>
                    @endif
                    <li><a href="{{ url(route('logout')) }}">LogOut</a></li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="col-md-4 col-xs-offset-4 home"><marquee>Xin chao {{ Auth::user()->name }}</marquee></div>
    <div class="cotainer">
        @yield('manage_content')
    </div>
@endsection
