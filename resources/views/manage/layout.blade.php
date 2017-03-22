<!DOCTYPE html>
<html>
<head>
	<title>Admin page</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
  <!-- <script type="text/javascript" src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script> -->
</head>
<body>

<div class="container-fluid">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <!-- <a class="navbar-brand" href="{{ url(route('edit_user',Session::get('id'))) }}">Hello {{ Session::get('name') }}</a> -->
        </div>
        <ul class="nav navbar-nav">
          <li><a class="navbar-brand" href="{{ url(route('edit_user',Session::get('id'))) }}">Hello {{ Session::get('name') }}</a></li>
          <li><a href="{{ url(route('home')) }}">Home</a></li>
          <li><a href="{{ url(route('list_user')) }}">List user</a></li>
          <li><a href="{{ url(route('news')) }}">List news</a></li>
          @if(Session::get('id')==1)
          <li><a href="{{ url(route('deleted_acc')) }}">Deleted Account</a></li>
          @endif
          <li><a href="{{ url('sign_out') }}">Sign out</a></li>
        </ul>
      </div>
    </nav>
</div>
   

   <div class="container">
   	@yield('content')
   </div>

</body>
</html>