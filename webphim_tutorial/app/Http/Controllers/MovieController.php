<?php

namespace App\Http\Controllers;
use App\Models\Movie;
use App\Models\Movie_Genre;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Episode;
use Illuminate\Http\Request;
use Carbon\Carbon;
use File;
use Storage;
class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Movie::with('category','movie_genre','country','genre')->withCount('episode')->orderBy('id','DESC')->get();
        //category,genre,country la ten ham trong model Movie
        //return view('admincp.movie.index',compact('list','category','genre','country'));
        $category = Category::pluck('title','id');
        $country = Country::pluck('title','id');
        
        $destinationPath = public_path()."/json_file/";
        if(!is_dir($destinationPath)){
            mkdir($destinationPath,0777,true);
        }
        File::put($destinationPath.'movies.json',json_encode($list));
        return view('admincp.movie.index',compact('list','category','country'));

    }

    public function update_year(Request $request){

        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->year = $data['year'];
        //$movie->year = '2024';
        $movie->save();

    }
    public function update_season(Request $request){

        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->season = $data['season'];
        //$movie->year = '2024';
        $movie->save();

    }

    
    public function update_topview(Request $request){

        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->topview = $data['topview'];
        //$movie->year = '2024';
        $movie->save();

    }

    public function filter_topview(Request $request){

        $data = $request->all();
        $movie = Movie::where('topview',$data['value'])->orderBy('ngaycapnhat','DESC')->take('20')->get();
        $output = "";
        foreach($movie as $key => $mov){
            if($mov->resolution==0){
                    $text = 'HD';
                }elseif( $mov->resolution==1){
                    $text = 'SD';
                }elseif( $mov->resolution==2){
                    $text = 'HDCam';
                }elseif( $mov->resolution==3){
                    $text = 'CAM';
                }elseif( $mov->resolution==4){
                    $text = 'FHD';
                }else{
                    $text = 'Trailer';
            }
            $output.='<div class="item">
            <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                <div class="item-link">
                    <img src="'.url('uploads/movie/'.$mov->image).'" class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />
                    <span class="is_trailer">
                    '.$text.'
                    </span>
                </div>
                <p class="title">'.$mov->title.'</p>
            </a>
            <div class="viewsCount" style="color: #9d9d9d;">3,2k lượt xem </div>
            <div class="year" style="color: #9d9d9d;">'.$mov->year.'</div>
            <div style="float : left;">
            <ul class="list-inline rating"   title="Average Rating">';

            for($count=1; $count<=5; $count++){
         
            $output.='<li title="star_rating" style="font-size:20px; color: #ffcc00;padding:0;" 
               >&#9733;</li>';

            }
            $output.='</ul>
                <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;/* width: 100%; */">
                <span style="width: 0%"></span>
                </span>
            </div>
        </div>';
            
        }
        echo $output;

    }
   
    public function filter_default(Request $request){

        $data = $request->all();
        $movie = Movie::where('topview',0)->orderBy('ngaycapnhat','DESC')->take('20')->get();
        $output = "";
        foreach($movie as $key => $mov){
            if($mov->resolution==0){
                    $text = 'HD';
                }elseif( $mov->resolution==1){
                    $text = 'SD';
                }elseif( $mov->resolution==2){
                    $text = 'HDCam';
                }elseif( $mov->resolution==3){
                    $text = 'CAM';
                }elseif( $mov->resolution==4){
                    $text = 'FHD';
                } 
                else{
                    $text = 'Trailer';
            }
            $output.='<div class="item">
            <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                <div class="item-link">
                    <img src="'.url('uploads/movie/'.$mov->image).'" class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />
                    <span class="is_trailer">
                    '.$text.'
                    </span>
                </div>
                <p class="title">'.$mov->title.'</p>
            </a>
            <div class="viewsCount" style="color: #9d9d9d;">3,2k lượt xem </div>
            <div class="year" style="color: #9d9d9d;">'.$mov->year.'</div>
            <div style="float : left;">
            <ul class="list-inline rating"   title="Average Rating">';

            for($count=1; $count<=5; $count++){
         
            $output.='<li title="star_rating" style="font-size:20px; color: #ffcc00;padding:0;" 
               >&#9733;</li>';

            }
            $output.='</ul>
                <span class="user-rate-image post-large-rate stars-large-vang" style="display: block;/* width: 100%; */">
                <span style="width: 0%"></span>
                </span>
            </div>
        </div>';
            
        }
        echo $output;

    }

    public function category_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->category_id = $data['category_id'];
        $movie->save();

    }

    public function country_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->country_id = $data['country_id'];
        $movie->save();

    }
    public function phimhot_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->phim_hot = $data['phimhot_value'];
        $movie->save();

    }
    public function phude_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->phude = $data['phude_value'];
        $movie->save();

    }
    public function loaiphim_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->thuocphim = $data['loaiphim_value'];
        $movie->save();

    }
    public function resolution_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->resolution = $data['resolution_value'];
        $movie->save();

    }
    

    public function status_choose(Request $request){
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie->status = $data['status_value'];
        $movie->save();

    }

    public function update_image_movie_ajax(Request $request){
        $get_image = $request->file('file');
        $movie_id  = $request->movie_id;
        
        if($get_image){
            $movie = Movie::find($movie_id );
            unlink('uploads/movie/'.$movie->image);
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move( 'uploads/movie/',$new_image);
            $movie->image = $new_image; 
            $movie->save();
        }

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $country = Country::pluck('title','id');

        $list_genre = Genre::all();
        //$list = Movie::with('category','genre','country')->orderBy('id','DESC')->get();
        //category,genre,country la ten ham trong model Movie
        return view('admincp.movie.form',compact('category','genre','country','list_genre'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$data = $request->all();
        $data = $request->validate([
            'title' => ['required', 'unique:movies', 'max:255'],
            'slug' => ['required', 'unique:movies', 'max:255'],
            'sotap' => ['required'],
            'tags' => ['required'],
            'thuocphim' => ['required'],
            'season' => ['required'],
            'topview' => ['required'],
            'thoiluong' => ['required'],
            'year' => ['required'],
            'phude' => ['required'],
            'resolution' => ['required'],
            'name_eng' => ['required'],
            'phim_hot' => ['required'],
            
            'description' => ['required'],
            'status' => ['required'],
            'category_id' => ['required'],
            'genre' => ['required'],
            'country_id' => ['required'],
            'image' => ['required','image','mimes:jpg,png,jpeg,gif,svg','max:2048','dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'],

            ],
            [
                'title.unique' => ' Tên phim này đã có , xin điền tên khác ' ,
                'slug.unique' => ' Slug phim này đã có , xin điền Slug khác ' ,
                'title.required' => ' Vui lòng điền tên phim ' ,
                'description.required' => ' Vui lòng điền mô tả ' ,
                'slug.required' => ' Vui lòng điền Slug phim ' ,
                'status.required' => ' Vui lòng chọn trạng thái ' ,
                'sotap.required' => ' Vui lòng chọn số tập ' ,
                'tags.required' => ' Vui lòng điền tags ' ,
                'thuocphim.required' => ' Vui lòng chọn loại phim ' ,
                'season.required' => ' Vui lòng chọn season ' ,
                'topview.required' => ' Vui lòng chọn topview ' ,
                'thoiluong.required' => ' Vui lòng điền thời lượng ' ,
                'year.required' => ' Vui lòng chọn năm ' ,
                'phude.required' => ' Vui lòng chọn phụ đề ' ,
                'resolution.required' => ' Vui lòng chọn chất lượng ' ,
                'name_eng.required' => ' Vui lòng điền tên tiếng anh ' ,
                'phim_hot.required' => ' Vui lòng chọn phim hot ' ,
                
                'category_id.required' => ' Vui lòng chọn danh mục ' ,
                'genre.required' => ' Vui lòng chọn thể loại ' ,
                'country_id.required' => ' Vui lòng chọn quốc gia ' ,
                'image.required' => ' Vui lòng chọn ảnh ' ,
            ]);
        $movie = new Movie();
        $movie->title = $data['title'];
        $movie->tags = $data['tags'];
        $movie->sotap = $data['sotap'];
        $movie->trailer = $data['trailer'];
        $movie->thuocphim = $data['thuocphim'];
        $movie->season = $data['season'];
        $movie->topview = $data['topview'];
        $movie->thoiluong = $data['thoiluong'];
        $movie->year = $data['year'];
        $movie->phude = $data['phude'];
        $movie->resolution = $data['resolution'];
        $movie->name_eng = $data['name_eng'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        //$movie->genre_id = $data['genre_id'];
        foreach($data['genre'] as $key => $gen){
            $movie->genre_id = $gen[0];
        }

        $movie->country_id = $data['country_id'];
        $movie->ngaytao = Carbon::now('Asia/Ho_Chi_Minh');
        $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');
        // them anh 
        $get_image = $request->file('image');

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move( 'uploads/movie/',$new_image);
            $movie->image = $new_image; 
        }
        $movie->save();
        $movie->movie_genre()->attach($data['genre']);
        toastr()->success('Thành công',' Thêm phim ');
        return redirect()->back(); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $country = Country::pluck('title','id');
        //$list = Movie::with('category','genre','country')->orderBy('id','DESC')->get();
        //category,genre,country la ten ham trong model Movie
        $list_genre = Genre::all();
        $movie = Movie::find($id);
        $movie_genre = $movie->movie_genre;
        return view('admincp.movie.form',compact('list_genre','category','genre','country','movie','movie_genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //$data = $request->all();
        $data = $request->validate([
            'title' => ['required', 'max:255'],
            'slug' => ['required', 'max:255'],
            'sotap' => ['required'],
            'tags' => ['required'],
            'thuocphim' => ['required'],
            'season' => ['required'],
            'topview' => ['required'],
            'thoiluong' => ['required'],
            'year' => ['required'],
            'phude' => ['required'],
            'resolution' => ['required'],
            'name_eng' => ['required'],
            'phim_hot' => ['required'],
            'trailer' => ['nullable'],
            
            'description' => ['required'],
            'status' => ['required'],
            'category_id' => ['required'],
            'genre' => ['required'],
            'country_id' => ['required'],

            ],
            [
            
                'title.required' => ' Vui lòng điền tên phim ' ,
                'description.required' => ' Vui lòng điền mô tả ' ,
                'slug.required' => ' Vui lòng điền Slug phim ' ,
                'status.required' => ' Vui lòng chọn trạng thái ' ,
                'sotap.required' => ' Vui lòng chọn số tập ' ,
                'tags.required' => ' Vui lòng điền tags ' ,
                'thuocphim.required' => ' Vui lòng chọn loại phim ' ,
                'season.required' => ' Vui lòng chọn season ' ,
                'topview.required' => ' Vui lòng chọn topview ' ,
                'thoiluong.required' => ' Vui lòng điền thời lượng ' ,
                'year.required' => ' Vui lòng chọn năm ' ,
                'phude.required' => ' Vui lòng chọn phụ đề ' ,
                'resolution.required' => ' Vui lòng chọn chất lượng ' ,
                'name_eng.required' => ' Vui lòng điền tên tiếng anh ' ,
                'phim_hot.required' => ' Vui lòng chọn phim hot ' ,
                
                'category_id.required' => ' Vui lòng chọn danh mục ' ,
                'genre.required' => ' Vui lòng chọn thể loại ' ,
                'country_id.required' => ' Vui lòng chọn quốc gia ' ,
                
            ]);

        $movie = Movie::find($id);
        $movie->title = $data['title'];
        $movie->tags = $data['tags'];
        $movie->sotap = $data['sotap'];
        $movie->thuocphim = $data['thuocphim'];
        $movie->trailer = $data['trailer'];
        $movie->season = $data['season'];
        $movie->topview = $data['topview'];
        $movie->thoiluong = $data['thoiluong'];
        $movie->year = $data['year'];
        $movie->phude = $data['phude'];
        $movie->resolution = $data['resolution'];
        $movie->name_eng = $data['name_eng'];
        $movie->phim_hot = $data['phim_hot'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->status = $data['status'];
        $movie->category_id = $data['category_id'];
        //$movie->genre_id = $data['genre_id'];
        foreach($data['genre'] as $key => $gen){
            $movie->genre_id = $gen[0];
        }

        $movie->country_id = $data['country_id'];
        $movie->ngaycapnhat = Carbon::now('Asia/Ho_Chi_Minh');
        // them anh 
        $get_image = $request->file('image');

        if($get_image){

            if(file_exists('uploads/movie/'.$movie->image)){
                if($movie->image != NULL) unlink('uploads/movie/'.$movie->image);
                else {
                    $get_name_image = $get_image->getClientOriginalName();
                    $name_image = current(explode('.',$get_name_image));
                    $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
                    $get_image->move( 'uploads/movie/',$new_image);
                    $movie->image = $new_image;
                } 
            }else{

            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move( 'uploads/movie/',$new_image);
            $movie->image = $new_image; 
            }
        }
        
        $movie->save();

        /// them nhieu the loai cho phim
         
        $movie->movie_genre()->sync($data['genre']);
        toastr()->success('Thành công',' Cập nhật phim ');

        return redirect()->route('movie.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {   

        // xoa anh 
        $movie = Movie::find($id);
        if(file_exists('uploads/movie/'.$movie->image)){
            unlink('uploads/movie/'.$movie->image);
        }
        
        //xoa the loai 
        
        Movie_Genre::whereIn('movie_id',[$movie->id])->delete();

        Episode::whereIn('movie_id',[$movie->id])->delete();
        
        $movie->delete();
        toastr()->warning('Thành Công',' Xóa Phim ');
       return redirect()->back();
    }
}
