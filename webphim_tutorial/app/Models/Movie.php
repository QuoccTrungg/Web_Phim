<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public $timestamps = false;
    use HasFactory;

    public function category(){
        return $this->belongsTo(Category::class,'category_id','id'); 
        //category_id la khoa ngoai // id la khoa chinh
        // mot phim chi co 1 category
    }
    public function country(){
        return $this->belongsTo(Country::class,'country_id','id');//country_id la khoa ngoai // id la khoa chinh
        
    }
    public function genre(){

        return $this->belongsTo(Genre::class,'genre_id','id');//genre_id la khoa ngoai // id la khoa chinh
    }

    public function movie_genre(){

        return $this->belongsToMany(Genre::class,'movie_genre','movie_id','genre_id');//genre_id la khoa ngoai // id la khoa chinh
    }

    public function episode(){

        return $this->HasMany(Episode::class,'movie_id');//movie_id la khoa ngoai // id la khoa chinh
    }

}
