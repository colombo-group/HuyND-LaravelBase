<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My pages</title>
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
</head>
<body>
<div class="container-fluid">
    <div class="top">
        <div class="col-lg-6">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <ul class="nav navbar-nav navbar-left">
                        <li><a href="{{ url(route('front_home')) }}">Home</a></li>
                        <li><a href="{{ url(route('front_list_news')) }}">Pages</a></li>
                        <li><a href="#">About</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="col-md-1 pull-right admin_conn">
            <a href="{{ url(route('home')) }}">Manager</a>
        </div>
    </div>
</div>
<div class="container">
    @yield('front_content')
</div>
</body>
</html>
