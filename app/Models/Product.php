<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";
    protected $primaryKey = 'id_product';
    protected $fillable = [
        'id_cat', 
        'name', 
        'slug',
        'description',
        'price',
        'stock',
        'image',
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id_cat');
    }

    public function variants(){
        return $this->hasMany(ProductVariant::class, 'product_id', 'id_product');
    }

    public function reviews(){
        return $this->hasMany(Review::class, 'product_id', 'id_product');
    }

    public function wishlists(){
        return $this->hasMany(Wishlist::class, 'product_id', 'id_product');
    }

    public function carts(){
        return $this->hasMany(Cart::class, 'product_id', 'id_product');
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class, 'product_id', 'id_product');
    }
}
