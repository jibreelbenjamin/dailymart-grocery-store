<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = "carts";
    protected $primaryKey = 'id_cart';
    protected $fillable = [
        'user_id', 
        'product_id', 
        'variant_id', 
        'stock', 
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id_product');
    }

    public function variant(){
        return $this->belongsTo(ProductVariant::class, 'variant_id', 'id_variant');
    }
}
