@extends('layouts.app')

@section('content')
<div class="container">
        <a href="{{route('episode.index')}}" class="btn btn-primary">Liệt kê tập phim</a>
    <div class="row justify-content-center">
        
        <div class="col-md-12">
            <div class="card">
                
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
                        {!! Form::label('movie','Tập phim',[]) !!}
                        {!! Form::select('movie_id',[''=>'Chọn phim','Phim'=> $list_movie],isset($episode) ? $episode->movie_id : '',['class'=>'form-control select-movie', isset($episode) ? 'readonly' : '']) !!}                  
                        </div>

                        <div class ="form-group">
                        {!! Form::label('Link','Link',[]) !!}
                        {!! Form::text('linkphim',isset($episode) ? $episode->linkphim : '',['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...']) !!}                  
                        </div>


                        {{-- <--lay  danh sach tap phim theo phim--> --}}
                        {{-- <div class ="form-group">
                        {!! Form::label('episode','Tập phim',[]) !!}
                            <select name="episode" class="form-control" id="show_movie">
                                
                            
                            </select>
                                
                        </div> --}}
                        @if(isset($episode))
                            <div class ="form-group">
                            {!! Form::label('episode','Tập phim',[]) !!}
                            {!! Form::text('episode',isset($episode) ? $episode->episode : '',['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu...',isset($episode) ? 'readonly' : '']) !!}                  
                            </div>
                        @else
                            <div class ="form-group">
                            {!! Form::label('episode','Tập phim',[]) !!}
                                <select name="episode" class="form-control" id="show_movie">
                                    
                                
                                </select>
                                    
                            </div>
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
    </div>
</div>


 
@endsection
