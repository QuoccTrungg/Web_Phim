@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        
         <div class="col-md-12">
            <div class="card">
                <a href="{{route('episode.index')}}" class="btn btn-primary">Liệt kê tập phim</a>
                <div class="card-header">Quản lý Tập phim</div>
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
                    @if(!isset($episode))
                        {!! Form::open(['route' =>'episode.store','method'=>'POST','enctype'=>'multipart/form-data']) !!}
                    @else
                        {!! Form::open(['route' =>['episode.update',$episode->id],'method'=>'PUT','enctype'=>'multipart/form-data']) !!}
                    @endif
                        
                         
                        <div class ="form-group">
                        {!! Form::label('movie_title','Tập phim',[]) !!}
                        {!! Form::text('movie_title',isset($movie) ? $movie->title : '',['class'=>'form-control','readonly']) !!}                  
                        {!! Form::hidden('movie_id',isset($movie) ? $movie->id : '') !!}
                        
                        </div>

                        <div class ="form-group">
                        {!! Form::label('Link','Link',[]) !!}
                        {!! Form::text('linkphim',isset($episode) ? $episode->linkphim : '',['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...']) !!}                  
                        </div>


                        {{-- <--lay  danh sach tap phim theo phim--> --}}
                        {{-- <div class ="form-group">
                        {!! Form::label('episode','Tập phim',[]) !!}
                            <select name="episode" class="form-control" id="show_movie">
                            @foreach($movie as $key->)    
                            
                            </select>
                                
                        </div> --}}
                        @if(isset($episode))
                            <div class ="form-group">
                            {!! Form::label('episode','Tập phim',[]) !!}
                            {!! Form::text('episode',isset($episode) ? $episode->episode : '',['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...',isset($episode) ? 'readonly' : '']) !!}                  
                            </div>
                        @else
                            @if($movie->thuocphim==1)
                            
                                <div class ="form-group">
                                {!! Form::label('episode','Tập phim',[]) !!}
                                {!! Form::selectRange('episode',1,$movie->sotap,$movie->sotap,['class'=>'form-control']) !!}
                                        
                                </div>
                            @else
                                <div class ="form-group">
                                {!! Form::label('episode','Tập phim',[]) !!}
                                    <select name="episode" class="form-control" id="show_movie">
                                        <option value="HD">HD</option>
                                        <option value="FullHD">FullHD</option>
                                        <option value="CAM">CAM</option>
                                    </select>
                                
                                </div>
                            @endif
                        @endif

                    @if(!isset($episode))
                        {!! Form::submit('Thêm Tập phim',['class'=>'btn btn-success']) !!}
                    @else
                        {!! Form::submit('Cập nhật',['class'=>'btn btn-success']) !!}
                    @endif
                        
                    {!! Form::close() !!}    
                </div>
            </div>
            
        </div>
        
        
        
        <!---------Liệt kê tập phim------->
        <div class="col-md-12">
            
            <table class="table" >
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên phim</th>
                    <th scope="col">Hình ảnh</th>
                    
                    <th scope="col">Tập phim</th>
                    <th scope="col">Link Phim</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Manager</th>
                    </tr>
                </thead>
                <tbody class ="order_position">
                  @foreach($list_episode as $key => $episode)
                    
                    <tr>
                    <th scope="row">{{$key}}</th>
                    <td>{{$episode->movie->title}}</td>
                    <td><img width="80%" src="{{asset('uploads/movie/'.$episode->movie->image)}}"></td>
                    <td>{{$episode->episode}}</td>
                    <td>{!! $episode->linkphim !!}</td>
                    <td>
                        {{-- @if($cate->status) Hiển thị
                        @else Không hiển thị 
                        @endif --}}
                        Có 
                    </td>
                    <td>
                       {!! Form::open(['method'=>'DELETE','route'=>['episode.destroy',$episode->id],'onsubmit'=>'return confirm("Xóa hay không")']) !!}
                       {!! Form::submit('Xóa',['class'=>'btn btn-danger']) !!}
                       {!! Form::close() !!}
                       <a href="{{route('episode.edit',$episode->id)}}" class="btn btn-warning">Sửa</a>
                    </td>
                    </tr>
                     
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
