<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Episode;
use App\Models\Movie;
use App\Models\Movie_Genre;
use App\Models\Rating;
use DB;
class IndexController extends Controller
{
   public function home(){

      $phimhot = Movie::withCount('episode')->where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();
      $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();
      $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();
      //$trailer = Movie::where('status',1)->where('resolution',5)->orderBy('ngaycapnhat','DESC')->take('10')->get();
      $category = Category::orderBy('id','DESC')->where('status',1)->get();
      $genre = genre::orderBy('id','DESC')->get();
      $country = Country::orderBy('id','DESC')->get();
               //nested trong  laravel
      $category_home = Category::with(['movie'=> function($q){ $q->withCount('episode')->where('status',1); }])->orderBy('id','DESC')->where('status',1)->get();
      //movie la ten ham trong model category
    return view('pages.home',compact('category','genre','country','category_home','phimhot','phimhot_sidebar','phimhot_trailer'));
   }
  
   public function category($slug){
      $category = Category::orderBy('id','DESC')->where('status',1)->get();
      $genre = genre::orderBy('id','DESC')->get();
      $country = Country::orderBy('id','DESC')->get();
      $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();

      
      $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();
      $cate_slug = Category::where('slug',$slug)->first();
      $movie = Movie::withCount('episode')->where('category_id',$cate_slug->id)->orderBy('ngaycapnhat','DESC')->paginate(40);
      return view('pages.category',compact('phimhot_trailer','phimhot_sidebar','category','genre','country','cate_slug','movie'));
   }
   
   public function genre($slug){
      $category = Category::orderBy('id','DESC')->where('status',1)->get();
      $genre = genre::orderBy('id','DESC')->get();
      $country = Country::orderBy('id','DESC')->get();
      $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();

     

      $phimhot_sidebar = Movie::withCount('episode')->where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();
      $genre_slug = Genre::where('slug',$slug)->first();
      
      $movie_genre = Movie_Genre::where('genre_id',$genre_slug->id)->get();
      $many_genre = [];
      foreach($movie_genre as $key => $movi){
         $many_genre[] = $movi->movie_id;
      }
      $movie = Movie::withCount('episode')->whereIn('id',$many_genre)->orderBy('ngaycapnhat','DESC')->paginate(40);

      return view('pages.genre',compact('phimhot_trailer','phimhot_sidebar','category','genre','country','genre_slug','movie'));
   }
   
   public function country($slug){
      $category = Category::orderBy('id','DESC')->where('status',1)->get();
      $genre = genre::orderBy('id','DESC')->get();
      $country = Country::orderBy('id','DESC')->get();
      $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();
      $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();


      $country_slug = Country::where('slug',$slug)->first();
      $movie = Movie::withCount('episode')->where('country_id',$country_slug->id)->orderBy('ngaycapnhat','DESC')->paginate(40);
      return view('pages.country',compact('phimhot_trailer','phimhot_sidebar','category','genre','country','country_slug','movie'));
   }
   
   public function movie($slug){
      //lay danh sach phim cung category
      $category = Category::orderBy('id','DESC')->where('status',1)->get();
      $genre = genre::orderBy('id','DESC')->get();
      $country = Country::orderBy('id','DESC')->get();
      $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();


      $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();
      $movie = Movie::with('category','genre','country','movie_genre')->where('slug',$slug)->where('status',1)->first();
      $related = Movie::with('category','genre','country')->where('category_id',$movie->category->id)->where('status',1)->orderBy(DB::raw('RAND()'))->whereNotIn('resolution',[5])->whereNotIn('slug',[$slug])->get();

      $episode_tapdau = Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode','ASC')->first();
     
     // lấy 3  tập gần nhất
      $episode = Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode','DESC')->take(3)->get();
      
      // lấy  tổng tập phi đã  thêm 
      $episode_list = Episode::with('movie')->where('movie_id',$movie->id)->get();
   
      $ep_count =  $episode_list->count();

      $rating = Rating::where('movie_id',$movie->id)->avg('rating');
      $rating = round($rating);

      $count_total = Rating::where('movie_id',$movie->id)->count();

      return view('pages.movie',compact('phimhot_trailer','phimhot_sidebar','category','genre','country','movie','related','episode','episode_tapdau','ep_count','rating','count_total'));
   }
   
   public function add_rating(Request $request){
      $data = $request->all();
      $ip_address = $request->ip();
      $rating_count = Rating::where('movie_id',$data['movie_id'])->where('ip_address',$ip_address)->count();
      if($rating_count>0){
         echo 'exist';
      }else{
         $rating = new Rating();
         $rating->movie_id = $data['movie_id'];
         $rating->rating = $data['index'];
         $rating->ip_address = $ip_address;
         $rating->save();
         echo 'done';
      }

   }

   public function year($year){
      $category = Category::orderBy('id','DESC')->where('status',1)->get();
      $genre = genre::orderBy('id','DESC')->get();
      $country = Country::orderBy('id','DESC')->get();

      $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();

      $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();
      $year = $year;

      $movie = Movie::withCount('episode')->where('year',$year)->orderBy('ngaycapnhat','DESC')->paginate(40);
      return view('pages.year',compact('phimhot_trailer','phimhot_sidebar','category','genre','country','movie','year'));
   }

   public function tag($tag){
      $category = Category::orderBy('id','DESC')->where('status',1)->get();
      $genre = genre::orderBy('id','DESC')->get();
      $country = Country::orderBy('id','DESC')->get();

      $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();

      $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();
      $tag = $tag;

      $movie = Movie::withCount('episode')->where('tags','LIKE','%'.$tag.'%')->orderBy('ngaycapnhat','DESC')->paginate(40);
      return view('pages.tag',compact('phimhot_trailer','phimhot_sidebar','category','genre','country','movie','tag'));
   }


   public function locphim(){
      $category = Category::orderBy('id','DESC')->where('status',1)->get();
      $genre = genre::orderBy('id','DESC')->get();
      $country = Country::orderBy('id','DESC')->get();
      $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();
      $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();
      //$cate_slug = Category::where('slug',$slug)->first();
      
      $sapxep = $_GET['order'];
      $gen = $_GET['genre'];
      $ctr = $_GET['country'];
      $year = $_GET['year'];
      
      if($sapxep=='' && $genre=='' && $country=='' && $year==''){
         return redirect()->back();
      }else{
         $list_movie = Movie::select('id')->whereHas('movie_genre', function($query) use ($gen) {
            $query->where('genre_id', $gen);
        })->get();
        $list =[]; 
        foreach($list_movie as $key => $mov){
         $list[]=$mov->id;
         }
         //dd($list);
         $movie = Movie::withCount('episode');
         if($gen) $movie =$movie->whereIn('id',$list);
         if($ctr) $movie =$movie->where('country_id',$ctr);
         if($year) $movie =$movie->where('year',$year);
         if($sapxep) {
            if($sapxep=='year_release') $movie =$movie->orderBy('year','DESC')->paginate(40);
            elseif($sapxep=='name_a_z')   $movie =$movie->orderBy('title','ASC')->paginate(40);
            elseif($sapxep=='watch_views') $movie =$movie->orderBy('title','DESC')->paginate(40);
         }else $movie =$movie->orderBy('ngaycapnhat','DESC')->paginate(40);
         //$movie = Movie::withCount('episode')->where('country_id',$ctr)->whereIn('id',$list)->where('year',$year)->orderBy('ngaycapnhat','DESC')->paginate(40);
         return view('pages.locphim',compact('phimhot_trailer','phimhot_sidebar','category','genre','country','movie'));

      }

   }

   public function timkiem(){
      if(isset($_GET['search'])){
         $search =$_GET['search'];
         $category = Category::orderBy('id','DESC')->where('status',1)->get();
         $genre = genre::orderBy('id','DESC')->get();
         $country = Country::orderBy('id','DESC')->get();
         $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();
         $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();
         //$cate_slug = Category::where('slug',$slug)->first();
         
         $movie = Movie::withCount('episode')->where('title','LIKE','%'.$search.'%')->orderBy('ngaycapnhat','DESC')->paginate(40);
         
         
         return view('pages.timkiem',compact('phimhot_trailer','phimhot_sidebar','category','genre','country','search','movie'));
      } else {

        return redirect()->to('/');
      }
      
     
   }


   public function watch($slug,$tap){
      
     
      $category = Category::orderBy('id','DESC')->where('status',1)->get();
      $genre = genre::orderBy('id','DESC')->get();
      $country = Country::orderBy('id','DESC')->get();
      $phimhot_trailer = Movie::where('resolution',5)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('10')->get();


      $phimhot_sidebar = Movie::where('phim_hot',1)->where('status',1)->orderBy('ngaycapnhat','DESC')->take('5')->get();
      $movie = Movie::with('category','genre','country','movie_genre','episode')->where('slug',$slug)->where('status',1)->first();
      
      if(isset($tap)){
         $tapphim = $tap;
         $tapphim = substr($tap,4,20);
         $episode = Episode::where('movie_id',$movie->id)->where('episode',$tapphim)->first();
      }else {
         $tapphim = 1;
         $episode = Episode::where('movie_id',$movie->id)->where('episode',$tapphim)->first();
      }
      $related = Movie::with('category','genre','country')->where('category_id',$movie->category->id)->where('status',1)->orderBy(DB::raw('RAND()'))->whereNotIn('resolution',[5])->whereNotIn('slug',[$slug])->get();

      return view('pages.watch',compact('phimhot_trailer','phimhot_sidebar','category','genre','country','movie','episode','tapphim','related'));
   }


   public function episode(){
      return view('pages.episode');
   }


}
