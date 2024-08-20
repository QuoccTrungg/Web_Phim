<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <link href="//cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        
        <main class="py-4">
        
            <div class="container-fluid">
            @include('layouts.navbar')
            </div>
      
        @yield('content')
            
        </main>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    

    <script type="text/javascript" src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>


    <script type="text/javascript">
        $(document).on('change','.file_image',function(){
            var movie_id = $(this).data('movie_id');
            var files = $("#file-"+movie_id)[0].files;

            var image = document.getElementById("file-"+movie_id).files[0];
            var form_data = new FormData();


            form_data.append("file",document.getElementById("file-"+movie_id).files[0]);
            form_data.append("movie_id",movie_id);
        
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                
                url:"{{route('update-image-movie-ajax')}}",
                method:"POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,

                success: function(data){
                   location.reload();
                   $('#success_image').html('<span class="text-success"> Cập nhật hình ảnh thành công</span>');

                }
            });
        
        })
        
    </script>


    <script type="text/javascript">
        $('.resolution_choose').change(function(){
            var resolution_value = $(this).val();
            var movie_id = $(this).attr('id');

            
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                
                url:"{{route('resolution-choose')}}",
                method:"GET",
                data: {resolution_value:resolution_value , movie_id:movie_id },
                success: function(data){
                   alert('thay đổi định dạng phim thành công ');

                }
            });
           
            
        })
    
    
    </script>

    <script type="text/javascript">
        $('.loaiphim_choose').change(function(){
            var loaiphim_value = $(this).val();
            var movie_id = $(this).attr('id');

            
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                
                url:"{{route('loaiphim-choose')}}",
                method:"GET",
                data: {loaiphim_value:loaiphim_value , movie_id:movie_id },
                success: function(data){
                   alert('thay đổi loại phim thành công ');

                }
            });
           
            
        })
    
    
    </script>

    <script type="text/javascript">
        $('.status_choose').change(function(){
            var status_value = $(this).val();
            var movie_id = $(this).attr('id');

            
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                
                url:"{{route('status-choose')}}",
                method:"GET",
                data: {status_value:status_value , movie_id:movie_id },
                success: function(data){
                   alert('thay đổi trạng thái thành công ');

                }
            });
           
            
        })
    
    
    </script>



    <script type="text/javascript">
        $('.phude_choose').change(function(){
            var phude_value = $(this).val();
            var movie_id = $(this).attr('id');

            
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                
                url:"{{route('phude-choose')}}",
                method:"GET",
                data: {phude_value:phude_value , movie_id:movie_id },
                success: function(data){
                   alert('thay đổi phụ đề thành công ');

                }
            });
           
            
        })
    
    
    </script>



    <script type="text/javascript">
        $('.phimhot_choose').change(function(){
            var phimhot_value = $(this).val();
            var movie_id = $(this).attr('id');
             {{-- alert(phimhot_value);
            alert(movie_id); --}}

            
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                
                url:"{{route('phimhot-choose')}}",
                method:"GET",
                data: {phimhot_value:phimhot_value , movie_id:movie_id },
                success: function(data){
                   alert('thay đổi phim hot thành công ');

                }
            });
           
            
        })
    
    
    </script>


    <script type="text/javascript">
        $('.country_choose').change(function(){
            var country_id = $(this).val();
            var movie_id = $(this).attr('id');
            
            
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                
                url:"{{route('country-choose')}}",
                method:"GET",
                data: {movie_id:movie_id , country_id:country_id },
                success: function(data){
                   alert('thay đổi danh mục thành công ');

                }
            });
           
            
        })
    
    
    </script>

    <script type="text/javascript">
        $('.category_choose').change(function(){
            var category_id = $(this).val();
            var movie_id = $(this).attr('id');
            
            {{-- . là  lấy $(this).val() theo tên class , # là lấy $(this).val() theo id , dùng  $(this).attr('id') để lấy val() attribute id  trong class  --}}
            
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                
                url:"{{route('category-choose')}}",
                method:"GET",
                data: {movie_id:movie_id , category_id:category_id },
                success: function(data){
                   alert('thay đổi quốc gia  thành công ');

                }
            });
           
           
        })
    
    
    </script>


    <script type="text/javascript">
        $('.select-year').change(function(){
            var year = $(this).find(':selected').val();
            var id_phim = $(this).attr('id');
            //alert(id_phim);
            //alert(year);
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                {{-- //url:"{{route('update_year')}}", --}}
                url:"{{url('/update-year-phim')}}",
                method:"GET",
                data: {year:year,id_phim:id_phim},
                success: function(data){
                    alert('Thay  đổi năm phim '+year+' thành công');

                }
            });
        })
    </script>

     <script type="text/javascript">
        $('.select-season').change(function(){
            var season = $(this).find(':selected').val();
            var id_phim = $(this).attr('id');
            //alert(id_phim);
            //alert(year);
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                {{-- //url:"{{route('update_year')}}", --}}
                url:"{{url('/update-season-phim')}}",
                method:"GET",
                data: {season:season,id_phim:id_phim},
                success: function(data){
                    alert('Thay  đổi  phim season '+season+' thành công');

                }
            });
        })
    </script>

    <script type="text/javascript">
        $('.select-topview').change(function(){
            var topview = $(this).find(':selected').val();
            var id_phim = $(this).attr('id');
            //alert(id_phim);
            //alert(year);
            if(topview==0) var text = 'Ngày';
            else if (topview==1) var text = 'Tháng';
            else var text = 'Năm';
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                {{-- //url:"{{route('update_topview')}}", --}}
                url:"{{url('/update-topview')}}",
                method:"GET",
                data: {topview:topview,id_phim:id_phim},
                success: function(data){
                    alert('Thay  đổi top view '+text+' thành công');

                }
            });
        })
    </script>

    <script type="text/javascript">
    
    $(document).ready( function () {
    $('#tablephim').DataTable();
        } );

    function ChangeToSlug()
        {

            var slug;
         
            //Lấy text từ thẻ input title 
            slug = document.getElementById("slug").value;
            slug = slug.toLowerCase();
            //Đổi ký tự có dấu thành không dấu
                slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
                slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
                slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
                slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
                slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
                slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
                slug = slug.replace(/đ/gi, 'd');
                //Xóa các ký tự đặt biệt
                slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
                //Đổi khoảng trắng thành ký tự gạch ngang
                slug = slug.replace(/ /gi, "-");
                //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
                //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
                slug = slug.replace(/\-\-\-\-\-/gi, '-');
                slug = slug.replace(/\-\-\-\-/gi, '-');
                slug = slug.replace(/\-\-\-/gi, '-');
                slug = slug.replace(/\-\-/gi, '-');
                //Xóa các ký tự gạch ngang ở đầu và cuối
                slug = '@' + slug + '@';
                slug = slug.replace(/\@\-|\-\@|\@/gi, '');
                //In slug ra textbox có id “slug”
            document.getElementById('convert_slug').value = slug;
        }

    </script>

    <script type="text/javascript">
        $('.order_position').sortable({
            placeholder : 'ui-state-highlight',    
            update: function(event,ui){
                var array_id = [];
                 $('.order_position tr').each(function(){

                    array_id.push($(this).attr('id'));
                })
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('resorting')}}",
                    method: "POST",
                    data: {array_id:array_id},
                    success: function(data){

                        alert(' Sap xep thanh cong');
                    }

                })
            }
        })
    
    
    </script>

    <script type="text/javascript">
        $('.select-movie').change(function(){
            var id = $(this).find(':selected').val();
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                
                url:"{{route('select-movie')}}",
                method:"GET",
                data: {id:id},
                success: function(data){
                    $('#show_movie').html(data);

                }
            });
        })
    </script>

</body>
</html>
