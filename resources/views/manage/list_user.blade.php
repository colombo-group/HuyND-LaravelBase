@extends('home')
@section('manage_content')
    <div class="col-md-8 col-xs-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">List User</div>
            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th style="width:100px;"></th>
                    </tr>

                    <?php
                    foreach($user as $rows)
                    {
                    ?>
                    <tr>
                        <td>{{ $rows->name }}</td>
                        <td>{{ $rows->email }}</td>
                        <td>
                            @if($rows->id_acc==1)
                                <div>Admin</div>
                            @else
                                <div>User</div>
                            @endif
                        </td>
                        <td >

                            @if($rows->id==Auth::id()||($rows->id_acc==2&&Auth::user()->id_acc==1))
                                <a href="{{ url('manage/edit_user/'.$rows->id) }}">Edit</a>&nbsp;
                            @endif
                            @if($rows->id_acc==2&&Auth::user()->id_acc==1)
                                <a href="{{ url(route('delete',$rows->id)) }}" onclick="return window.confirm('Are you sure?');">Delete</a>
                            @endif
                        </td>
                    </tr>
                    <?php } ?>
                </table>
                {{ $user->links() }}
            </div>
        </div>
    </div>
@endsection