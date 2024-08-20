

<form action="{{route('locphim')}}" method="GET">
                        <style type="text/css">
                           .stylish_filter{
                              border: 0;
                              background: #12171b;
                              color: #fff;
                               }
                        </style>
                        
                        <div class="col-md-2">
                           <div class="form-group">
                                 <select class="form-control stylish_filter" name="order" aria-label="Default select example">
                                 <option selected value="">---Sắp xếp--- </option>
                                 <option value="date">Ngày đăng</option>
                                 <option value="year_release">Năm sản xuất</option>
                                 <option value="name_a_z">Tên phim</option>
                                 <option value="watch_views">Lượt xem</option>
                                 </select>
                           </div>
                        </div>
                       
                        <div class="col-md-3">
                           <div class="form-group">
                                 <select class="form-control stylish_filter" name="genre" aria-label="Default select example">
                                 <option selected value="">---Thể loại---</option>
                                 @foreach($genre as $key  => $gen)
                                 <option {{ (isset($_GET['genre']) && $_GET['genre']==$gen->id) ? 'selected' : '' }} value="{{$gen->id}}">{{$gen->title}}</option>                                
                                 @endforeach
                                 </select>
                           </div>
                        </div>

                        <div class="col-md-3">
                           <div class="form-group">
                                 <select class="form-control stylish_filter" name="country" aria-label="Default select example">
                                 <option selected value="">---Quốc gia---</option>
                                 @foreach($country as $key  => $count) 
                                 <option {{ (isset($_GET['country']) && $_GET['country']==$count->id) ? 'selected' : '' }} value="{{$count->id}}">{{$count->title}}</option>                                
                                 @endforeach
                                 </select>
                           </div>
                        </div>

                        <div class="col-md-2">
                           <div class="form-group">

                              {{-- @php
                                 if(isset($_GET['year'])) $year = $_GET['year'];
                                 else $year = null; 
                              @endphp --}}

                                 <select class="form-control stylish_filter" name="year" aria-label="Default select example">
                                 <option selected value="">---Năm---</option>
                                 @for($year = 2015; $year <= 2024 ; $year++ ) 
                                 <option {{ (isset($_GET['year']) && $_GET['year']==$year) ? 'selected' : '' }} value="{{$year}}">{{$year}}</option>                                
                                 @endfor
                                 </select>
                                 {{-- {!! Form::selectYear('year',1995,2024,['class'=>'select-year','placeholder'=>'---Năm---']) !!} --}}

                           </div>
                        </div>
                        <div class="col-md-2">
                           <input type="submit"  class="btn btn-info" value="Lọc phim">
                        </div>
                     </form>
