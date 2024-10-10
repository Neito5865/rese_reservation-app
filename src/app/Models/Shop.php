<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'area_id',
        'genre_id',
        'shopName',
        'detail',
        'shopImg',
    ];

    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function genre(){
        return $this->belongsTo(Genre::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeAreaSearch($query, $area_id){
        if(!empty($area_id)){
            $query->where('area_id', $area_id);
        }
    }

    public function scopeGenreSearch($query, $genre_id){
        if(!empty($genre_id)){
            $query->where('genre_id', $genre_id);
        }
    }

    public function scopeKeywordSearch($query, $keyword){
        if(!empty($keyword)){
            $query->where('shopName', 'like', '%' . $keyword . '%');
        }
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

    public function favoriteUsers(){
        return $this->belongsToMany(User::class, 'favorites', 'shop_id', 'user_id')->withTimestamps();
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }
}
