@extends('home')
@section('manage_content')
    <div class="col-md-8 col-xs-offset-2">
        <div class="panel panel-primary">
            <a href="{{ url(route('add_news')) }}" class="btn btn-primary">Add News</a>
            <div class="panel-heading">List News</div>
            <div class="panel-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th class="col-md-3">Image</th>
                        <th>Title</th>
                        <th></th>
                    </tr>
                    @foreach($news as $row)
                   <tr>
                       <td>
                            <img src="{{ asset('upload/news/'.$row->img) }}">
                       </td>
                       <td>
                           {{ $row->title }}
                       </td>
                       <td>
                           <a href="{{ url(route('edit_news',$row->id)) }}">Edit</a>&nbsp;
                           <a href="{{ url(route('delete_news',$row->id)) }}">Delete</a>
                       </td>
                   </tr>
                     @endforeach
                </table>
                {{ $news->links() }}
            </div>
        </div>
    </div>
@endsection