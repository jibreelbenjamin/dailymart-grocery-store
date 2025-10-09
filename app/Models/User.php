<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = "users";
    protected $primaryKey = 'id_user';
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'role',
    ];

    public function carts(){
        return $this->hasMany(Cart::class, 'user_id', 'id_user');
    }

    public function orders(){
        return $this->hasMany(Order::class, 'user_id', 'id_user');
    }

    public function reviews(){
        return $this->hasMany(Review::class, 'user_id', 'id_user');
    }
}
