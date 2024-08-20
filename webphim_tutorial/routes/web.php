<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[IndexController::class, 'home'])->name('homepage');
Route::get('/danh-muc/{slug}',[IndexController::class, 'category'])->name('category');
Route::get('/the-loai/{slug}',[IndexController::class, 'genre'])->name('genre');
Route::get('/quoc-gia/{slug}',[IndexController::class, 'country'])->name('country');
Route::get('/phim/{slug}',[IndexController::class, 'movie'])->name('movie');
Route::get('/xem-phim/{slug}/{tap}',[IndexController::class, 'watch']);
Route::get('/episode',[IndexController::class, 'episode'])->name('episode');



Route::get('/so-tap',[IndexController::class, 'episode'])->name('so-tap');
Route::get('add-episode/{id}',[EpisodeController::class, 'add_episode'])->name('add-episode');

Route::get('/nam/{year}',[IndexController::class, 'year']);
Route::get('/tag/{tag}',[IndexController::class, 'tag']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');




//Route::get('update_year', [MovieController::class,'update_year'])->name('update_year');
Route::get('/update-year-phim', [MovieController::class,'update_year']);
Route::get('/update-season-phim', [MovieController::class,'update_season']);

Route::get('/update-topview', [MovieController::class,'update_topview']);
Route::get('/filter-topview-phim', [MovieController::class,'filter_topview']);
Route::get('/filter-topview-default', [MovieController::class,'filter_default']);

Route::get('/tim-kiem', [IndexController::class,'timkiem'])->name('tim-kiem');
Route::get('/locphim', [IndexController::class,'locphim'])->name('locphim');


Route::post('/add-rating', [IndexController::class,'add_rating'])->name('add-rating');



// route admin
Route::resource('category', CategoryController::class);
Route::post('resorting', [CategoryController::class, 'resorting'])->name('resorting');


Route::resource('genre', GenreController::class);
Route::resource('country', CountryController::class);
Route::resource('movie', MovieController::class);
Route::resource('episode', EpisodeController::class);
Route::get('select-movie',[EpisodeController::class,'select_movie'])->name('select-movie');


Route::get('/category-choose', [MovieController::class,'category_choose'])->name('category-choose');
Route::get('/country-choose', [MovieController::class,'country_choose'])->name('country-choose');
Route::get('/phimhot-choose', [MovieController::class,'phimhot_choose'])->name('phimhot-choose');
Route::get('/phude-choose', [MovieController::class,'phude_choose'])->name('phude-choose');
Route::get('/status-choose', [MovieController::class,'status_choose'])->name('status-choose');
Route::get('/loaiphim-choose', [MovieController::class,'loaiphim_choose'])->name('loaiphim-choose');
Route::get('/resolution-choose', [MovieController::class,'resolution_choose'])->name('resolution-choose');
Route::post('/update-image-movie-ajax', [MovieController::class,'update_image_movie_ajax'])->name('update-image-movie-ajax');