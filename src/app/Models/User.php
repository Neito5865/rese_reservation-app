<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function shops(){
        return $this->hasMany(Shop::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }


    public function favorites(){
        return $this->belongsToMany(Shop::class, 'favorites', 'user_id', 'shop_id');
    }

    public function favorite($shopId){
        $exist = $this->isFavorite($shopId);
        if($exist){
            return false;
        }else{
            $this->favorites()->attach($shopId, ['created_at' => now()]);
            return true;
        }
    }

    public function unfavorite($shopId){
        $exist = $this->isFavorite($shopId);
        if($exist){
            $this->favorites()->detach($shopId);
            return true;
        }else{
            return false;
        }
    }

    public function isFavorite($shopId){
        return $this->favorites()->where('shop_id', $shopId)->exists();
    }
}
