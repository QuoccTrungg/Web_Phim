@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
           <a href="{{route('movie.create')}}" class="btn btn-primary">Thêm phim</a> 

            <table class="table" id="tablephim">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>  
                    {{-- <th scope="col">Tags</th>   --}}
                    <th scope="col">Image</th>
                    {{-- <th scope="col">Description</th> --}}
                    <th scope="col">English Name</th>  
                    <th scope="col">Slug</th>
                    <th scope="col">Active</th>
                    <th scope="col">Phim Hot</th>
                    <th scope="col">Định dạng</th> 
                    <th scope="col">Thời lượng</th>
                    <th scope="col">Loại phim</th> 
                    <th scope="col">Phụ đề</th> 
                    <th scope="col">Danh mục</th>
                    
                    <th scope="col">Thể loại</th>
                    <th scope="col">Quốc gia</th>
                    <th scope="col">Số tập</th>
                    <th scope="col">Ngày tạo</th>
                    <th scope="col">Ngày cập nhật</th>
                    <th scope="col">Năm phim</th>
                    <th scope="col">Top views</th>
                    <th scope="col">Season</th>
                    <th scope="col">Manager</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $key => $movie)
                    <tr>
                    <th scope="row">{{$key}}</th>
                    <td>{{$movie->title}}</td>
                    {{-- <td>{{$movie->tags}}</td> --}}
                    <td>
                    
                    <img width="200" src="{{asset('uploads/movie/'.$movie->image)}}">
                    <input type="file" id="file-{{$movie->id}}" data-movie_id="{{$movie->id}}" class="form-control-file file_image" accept="image/*" >
                    
                    <span id="success_image"></span>
                    
                    </td>
                    {{-- <td>{{$movie->description}}</td> --}}
                    <td>{{$movie->name_eng}}</td>
                    <td>{{$movie->slug}}</td>
                    <td>
                        {{-- @if($movie->status) Hiển thị
                        @else Không hiển thị 
                        @endif --}}

                         <select  id="{{$movie->id}}" class=" status_choose">
                            <option {{ ($movie->status==1) ? 'selected' : '' }} value="1"> Hiển thị </option>
                            <option {{ ($movie->status==0) ? 'selected' : '' }} value="0"> Không </option>
                        </select>

                    </td>
                    <td>
                        {{-- @if($movie->phim_hot) Hot
                        @else Không 
                        @endif --}}


                        <select  id="{{$movie->id}}" class=" phimhot_choose">
                            <option {{ ($movie->phim_hot==1) ? 'selected' : '' }} value="1"> Hot </option>
                            <option {{ ($movie->phim_hot==0) ? 'selected' : '' }} value="0"> Không </option>
                        </select>


                    </td>
                    <td>
                        {{-- @if($movie->resolution==0) HD
                        @elseif($movie->resolution==1) SD 
                        @elseif($movie->resolution==2) HDCam 
                        @elseif($movie->resolution==3) CAM
                        @elseif($movie->resolution==4) FHD
                        @else Trailer
                        @endif --}}

                        @php
                            $options = array('0'=>'HD','1'=>'SD','2'=>'HDCam','3'=>'CAM','4'=>'FullHD','5'=>'Trailer')
                        @endphp
                        
                        <select  id="{{$movie->id}}" class=" resolution_choose">
                            @foreach($options as $key => $resolution )
                            <option {{ ($movie->resolution==$key) ? 'selected' : '' }} value="{{$key}}"> {{$resolution}} </option>
                            @endforeach
                        </select>
                    
                    
                    </td>
                    <td>{{$movie->thoiluong}}</td>
                    <td>
                    {{-- @if($movie->thuocphim==0) Phim lẻ
                        @else Phim bộ
                        @endif</td> --}}
                        
                        <select  id="{{$movie->id}}" class=" loaiphim_choose">
                            
                            
                            <option {{ ($movie->thuocphim==1) ? 'selected' : '' }} value="1"> Phim bộ </option>
                            <option {{ ($movie->thuocphim==0) ? 'selected' : '' }} value="0"> Phim lẻ </option>
                        </select>

                    <td>
                        {{-- @if($movie->phude) Thuyết minh  
                        @else Vietsub
                        @endif --}}
                        
                        <select  id="{{$movie->id}}" class=" phude_choose">
                            <option {{ ($movie->phude==1) ? 'selected' : '' }} value="1"> Thuyết minh </option>
                            <option {{ ($movie->phude==0) ? 'selected' : '' }} value="0"> Vietsub </option>
                        </select>

                    </td>
                    <td>
                    {{-- {{$movie->category->title}}  --}}
                    {!! Form::select('category_id',$category,isset($movie) ? $movie->category_id : '',['class'=>' category_choose','id'=>$movie->id]) !!}
                    </td>
                    
                    <td>  
                        @foreach($movie->movie_genre as $mov)
                           <span class="badge bg-dark">{{$mov->title}}</span>
                        @endforeach
                    </td>

                    
                    <td> 
                    {{-- {{$movie->country->title}}  --}}
                    {!! Form::select('country_id',$country,isset($movie) ? $movie->country_id : '',['class'=>' country_choose','id'=>$movie->id]) !!}

                    </td>
                    <td> {{$movie->episode_count}} / {{$movie->sotap}} Tập </td>
                    <td> {{$movie->ngaytao}} </td>
                    <td> {{$movie->ngaycapnhat}} </td>
                    <td> 
                    {!! Form::selectYear('year',1995,2024,isset($movie) ? $movie->year : '',['class'=>'select-year','id'=>$movie->id]) !!}
                     </td>
                     <td> 
                        {!! Form::select('topview',['0'=>'Ngày','1'=>'Tuần','2'=>'Tháng'],isset($movie) ? $movie->topview : '',['class'=>'select-topview','id'=>$movie->id]) !!} 
                     </td>
                     <td> 
                     <form method ="POST">
                        @csrf
                        
                        {!! Form::selectRange('season',0,20 ,isset($movie) ? $movie->season : '',['class'=>'select-season','id'=>$movie->id]) !!} 
                     
                     </form>
                     </td>
                    <td>
                       {!! Form::open(['method'=>'DELETE','route'=>['movie.destroy',$movie->id],'onsubmit'=>'return confirm("Xóa hay không")']) !!}
                       {!! Form::submit('Xóa',['class'=>'btn btn-danger']) !!}
                       {!! Form::close() !!}
                       <a href="{{route('movie.edit',$movie->id)}}" class="btn btn-warning">Sửa</a>
                       <a href="{{route('add-episode',$movie->id)}}" class="btn btn-primary">Thêm tập</a> 
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
