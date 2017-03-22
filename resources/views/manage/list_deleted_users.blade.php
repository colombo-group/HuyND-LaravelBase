@extends('home')
@section('manage_content')
<div class="col-md-8 col-xs-offset-2">
	<div class="panel panel-primary">
		<div class="panel-heading">List Users Deleted</div>
		<div class="panel-body">
			<table class="table table-bordered table-hover">
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th></th>
				</tr>
			<?php
				foreach($deleted_users as $rows)
				{
			?>
				<tr>
					<td>{{ $rows->name }}</td>
					<td>{{ $rows->email }}</td>
					<td style="text-align:center;">
						<a href="{{ url(route('delete_forever',$rows->id)) }}">Delete forever</a>&nbsp;
						<a href="{{ url(route('restore',$rows->id)) }}" onclick="return window.confirm('Are you sure?');">Restore</a>
					</td>
				</tr>
			<?php } ?>
			</table>
			{{ $deleted_users->links() }}
		</div>
	</div>
</div>
@endsection