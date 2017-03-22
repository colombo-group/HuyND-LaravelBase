@extends('home')
@section('manage_content')
<div class="signin col-md-8 col-xs-offset-2">
	<div class="panel panel-primary">
		<div class="panel-heading">Edit {{ $user->name }}'s infor</div>
		<div class="panel-body">
		<form method="post" action="">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="row">
				<!-- <?php //echo $data->email; ?> -->
				<div class="col-md-3">Email *</div>
				<div class="col-md-8"><input class="form-control" type="email" name="email" value="{{ $user->email }}" {{ Auth::user()->id_acc==1?'required':'disabled' }} ></div>
			</div>
			@if(Request::get('erro_exist1')!="")
			<div class="row"><div class="col-md-9 col-xs-offset-3">{{ Request::get('erro_exist1') }}</div></div>
			@endif
			<div class="row">
				<div class="col-md-3">Username *</div>
				<div class="col-md-8"><input class="form-control" type="text" name="username" value="{{ $user->username }}" {{ Auth::user()->id_acc==1?'required':'disabled' }} ></div>
			</div>
			@if(Request::get('erro_exist2')!="")
			<div class="row"><div class="col-md-9 col-xs-offset-3">{{ Request::get('erro_exist2') }}</div></div>
			@endif
			<div class="row">
				<div class="col-md-3">Full name *</div>
				<div class="col-md-8"><input class="form-control" type="text" name="fullname" value="{{ $user->name }}" required></div>
			</div>
			<div class="row">
				<div class="col-md-3">Password</div>
				<div class="col-md-8"><input type="password" name="password1" class="form-control" placeholder="Enter if you want to change your password"></div>
			</div>
			@if(Request::get('erro')!="")
			<div class="row"><div class="col-md-9 col-xs-offset-3">{{ Request::get('erro') }}</div></div>
			@endif
			<div class="row">
				<div class="col-md-3">Password</div>
				<div class="col-md-8"><input type="password" name="password2" class="form-control" placeholder="Enter again if you want to change your password"></div>
			</div>
			@if(Request::get('erro')!="")
			<div class="row"><div class="col-md-9 col-xs-offset-3">{{ Request::get('erro') }}</div></div>
			@endif
			<div class="row">
				<div class="col-md-3">Gender</div>
				<div class="col-md-8">
					<div class="col-md-4">
						Male: <input type="radio" name="gender" value="Male" {{ $user->gender=='Male'||$user->gender==null?'checked':'' }}>
					</div>
					<div class="col-md-4">
						Female: <input type="radio" name="gender" value="Female" {{ $user->gender=='Female'?'checked':'' }}>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">Slogan</div>
				<div class="col-md-8"><input type="text" class="form-control" name="slogan" value="{{ isset($user->slogan)?$user->slogan:'' }}"></div>
			</div>

			<div class="row">
				<div class="col-md-3">Birthday</div>
				<div class="col-md-8"><input class="form-control" type="date" name="birthday" value="{{ isset($user->birthday)?$user->birthday:'' }}"></div>
			</div>
			<div class="row">
				<div class="col-md-3">Address</div>
				<div class="col-md-8"><input type="text" class="form-control" name="address" value="{{ isset($user->address)?$user->address:'' }}"></div>
			</div>
			<div class="row">
				<div class="col-md-6"></div>
				<div class="col-md-3"><input type="submit" class="btn btn-primary" value="Save"></div>
			</div>
		</div>
		</form>
	</div>
</div>
@endsection