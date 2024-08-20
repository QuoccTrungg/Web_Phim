@extends('layouts.app')

@section('content')
<div class="container">
<a href="{{route('movie.index')}}" class="btn btn-primary">Liệt kê phim</a>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                
                <div class="card-header">Quản lý phim</div>
                @if($errors->any())
                    <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach                    
                    </ul>
                    </div>
                @endif  
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(!isset($movie))
                        {!! Form::open(['route' =>'movie.store','method'=>'POST','enctype'=>'multipart/form-data']) !!}
                    @else
                        {!! Form::open(['route' =>['movie.update',$movie->id],'method'=>'PUT','enctype'=>'multipart/form-data']) !!}
                    @endif
                        <div class ="form-group">
                        {!! Form::label('title','Title',[]) !!}
                        {!! Form::text('title',isset($movie) ? $movie->title : '',['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','id'=>'slug','onkeyup'=>'ChangeToSlug()']) !!}                  
                        </div>

                        <div class ="form-group">
                        {!! Form::label('English Name','English Name',[]) !!}
                        {!! Form::text('name_eng',isset($movie) ? $movie->name_eng : '',['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...']) !!}                  
                        </div>

                        <div class ="form-group">
                        {!! Form::label('Year','Year',[]) !!}
                        {!! Form::text('year',isset($movie) ? $movie->year : '',['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...']) !!}                  
                        </div>
                        
                        <div class ="form-group">
                        {!! Form::label('Season','Season',[]) !!}
                        {!! Form::selectRange('season',0,20 ,isset($movie) ? $movie->season : '',['class'=>'form-control']) !!}                  
                        </div>

                        <div class ="form-group">
                        {!! Form::label('thoiluong ','Thời lượng phim',[]) !!}
                        {!! Form::text('thoiluong',isset($movie) ? $movie->thoiluong : '',['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...']) !!}                  
                        </div>
                        
                         <div class ="form-group">
                        {!! Form::label('thuocphim','Thuộc thể loại phim',[]) !!}
                        {!! Form::select('thuocphim',['1'=>'Phim bộ','0'=>'Phim lẻ'],isset($movie) ? $movie->thuocphim : '',['class'=>'form-control']) !!}                  
                        </div> 

                        <div class ="form-group">
                        {!! Form::label('Sotap ','Số tập',[]) !!}
                        {!! Form::text('sotap',isset($movie) ? $movie->sotap : '',['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...']) !!}                  
                        </div>

                        <div class ="form-group">
                        {!! Form::label('slug','Slug',[]) !!}
                        {!! Form::text('slug',isset($movie) ? $movie->slug : '',['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','id'=>'convert_slug']) !!}                  
                        </div>
                        
                        <div class ="form-group">
                        {!! Form::label('Trailer','Trailer',[]) !!}
                        {!! Form::text('trailer',isset($movie) ? $movie->trailer : '',['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...']) !!}                  
                        </div>

                        <div class ="form-group">
                        {!! Form::label('description','Description',[]) !!}
                        {!! Form::textarea('description',isset($movie) ? $movie->description : '',['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...']) !!}                  
                        </div>

                        
                        
                        <div class ="form-group">
                        {!! Form::label('tags','Tags Phim',[]) !!}
                        {!! Form::textarea('tags',isset($movie) ? $movie->tags : '',['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...','id'=>'description']) !!}                  
                        </div>

                        <div class ="form-group">
                        {!! Form::label('Active','Active',[]) !!}
                        {!! Form::select('status',['1'=>'Hiển thị','0'=>'Không'],isset($movie) ? $movie->status : '',['class'=>'form-control']) !!}                  
                        </div>

                        <div class ="form-group">
                        {!! Form::label('Phụ đề','Phụ đề',[]) !!}
                        {!! Form::select('phude',['1'=>'Thuyết minh','0'=>'Vietsub'],isset($movie) ? $movie->phude : '',['class'=>'form-control']) !!}                  
                        </div>

                        <div class ="form-group">
                        {!! Form::label('resolution','Định dạng',[]) !!}
                        {!! Form::select('resolution',['0'=>'HD','1'=>'SD','2'=>'HDCam','3'=>'CAM','4'=>'FHD','5'=>'Trailer'],isset($movie) ? $movie->resolution : '',['class'=>'form-control']) !!}                  
                        </div>
                        
                        <div class ="form-group">
                        {!! Form::label('topview','Top view',[]) !!}
                        {!! Form::select('topview',['0'=>'Ngày','1'=>'Tuần','2'=>'Tháng'],isset($movie) ? $movie->topview : '',['class'=>'form-control']) !!}                  
                        </div>

                        <div class ="form-group">
                        {!! Form::label('Category','Category',[]) !!}
                        {!! Form::select('category_id',$category,isset($movie) ? $movie->category_id : '',['class'=>'form-control']) !!}                  
                        </div>

                        <div class ="form-group">
                        {!! Form::label('Country','Country',[]) !!}
                        {!! Form::select('country_id',$country,isset($movie) ? $movie->country_id : '',['class'=>'form-control']) !!}                  
                        </div>

                        <div class ="form-group">
                            {!! Form::label('Genre','Genre :',[]) !!}

                            @foreach($list_genre as $key => $gen)

                                @if(isset($movie))
                                    
                                    {!! Form::checkbox('genre[]',$gen->id, isset($movie_genre) && $movie_genre->contains($gen->id) ? true : false) !!}
                                @else
                                    
                                    {!! Form::checkbox('genre[]',$gen->id,'') !!}
                                @endif
                                {!! Form::label('genre',$gen->title) !!}             
                            @endforeach
                        </div>
                         
                        <div class ="form-group">
                        {!! Form::label('Hot','Hot',[]) !!}
                        {!! Form::select('phim_hot',['1'=>'Hot','0'=>'Không'],isset($movie) ? $movie->phim_hot : '',['class'=>'form-control']) !!}                  
                        </div>

                         <div class ="form-group">
                        {!! Form::label('Image','Image',[]) !!}
                        {!! Form::file('image',['class'=>'form-control-file']) !!}                  
                            @if(isset($movie))
                            <img width="30%" src="{{asset('uploads/movie/'.$movie->image)}}">
                            @endif
                        </div>
                    @if(!isset($movie))
                        {!! Form::submit('Thêm dữ liệu',['class'=>'btn btn-success']) !!}
                    @else
                        {!! Form::submit('Cập nhật',['class'=>'btn btn-success']) !!}
                    @endif
                        
                    {!! Form::close() !!}   
                </div>
            </div>
            {{-- <table class="table" id="tablephim">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>  
                    <th scope="col">Image</th>
                    <th scope="col">Description</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Active/Inactive</th>
                    <th scope="col">Category</th>
                    <th scope="col">Genre</th>
                    <th scope="col">Country</th>

                    <th scope="col">Manager</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $key => $movie)
                    <tr>
                    <th scope="row">{{$key}}</th>
                    <td>{{$movie->title}}</td>
                    <td><img width="60%" src="{{asset('uploads/movie/'.$movie->image)}}"></td>
                    <td>{{$movie->description}}</td>
                    <td>{{$movie->slug}}</td>
                    <td>
                        @if($movie->status) Hiển thị
                        @else Không hiển thị 
                        @endif
                    </td>
                    <td>{{$movie->category->title}} </td>
                    <td> {{$movie->genre->title}} </td>
                    <td> {{$movie->country->title}} </td>
                    <td>
                       {!! Form::open(['method'=>'DELETE','route'=>['movie.destroy',$movie->id],'onsubmit'=>'return confirm("Xóa hay không")']) !!}
                       {!! Form::submit('Xóa',['class'=>'btn btn-danger']) !!}
                       {!! Form::close() !!}
                       <a href="{{route('movie.edit',$movie ->id)}}" class="btn btn-warning">Sửa</a>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table> --}}
        </div>
    </div>
</div>
@endsection
