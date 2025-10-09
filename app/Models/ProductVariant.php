<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = "product_variants";
    protected $primaryKey = 'id_variant';
    protected $fillable = [
        'product_id', 
        'name', 
        'price',
        'stock',
        'image',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id_product');
    }

    public function carts(){
        return $this->hasMany(Cart::class, 'variant_id', 'id_variant');
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class, 'variant_id', 'id_variant');
    }
}
