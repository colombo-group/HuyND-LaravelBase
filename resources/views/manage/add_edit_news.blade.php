@extends('home')
@section('manage_content')
    <div class="col-md-8 col-xs-offset-2">
        <div class="panel panel-primary">
            <div class="panel-heading">Add or edit news</div>
            <div class="panel-body">
                <form method="post" action="" enctype= "multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <!-- row -->
                    <div class="row" style="margin-top:5px;">
                        <div class="col-md-3">Title</div>
                        <div class="col-md-9">
                            <input type="text" name="title" required class="form-control" value="{{ isset($arr->title)?$arr->title:"" }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">{{ Request::get('erro')!=null?Request::get('erro'):'' }}</div>
                    </div>
                    <!-- end row -->
                    <!-- row -->
                    <input type="hidden" name="img2" value="{{ isset($arr->img)?$arr->img:'' }}">
                    <div class="row" >
                        <div class="col-md-3">Image</div>
                        <div class="col-md-9">
                            <input type="file" name="img" {{ isset($arr->img)?'':'required' }}>
                        </div>
                    </div>
                    @if(isset($arr->img))
                        <div class="row col-xs-offset-3">
                            <img src="{{ asset('upload/news/'.$arr->img) }}">
                        </div>@endif
                <!-- end row -->
                    <!-- row -->
                    <div class="row" >
                        <div class="col-md-3">Content</div>
                        <div class="col-md-9">
					<textarea name="content" required class="form-control" >{{ isset($arr->content)?$arr->content:"" }}
                        {{ Request::get('content')!=null?Request::get('content'):'' }}
					</textarea>

                        </div>
                    </div>
                    <!-- end row -->


                    <!-- row -->
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            <input type="submit" class="btn btn-primary" value="Process">
                        </div>
                    </div>

                    <!-- end row -->
                </form>
            </div>
        </div>
    </div>
@endsection