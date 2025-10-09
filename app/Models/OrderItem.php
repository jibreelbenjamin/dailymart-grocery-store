<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = "order_items";
    protected $primaryKey = 'id_item';
    protected $fillable = [
        'order_id', 
        'product_id', 
        'variant_id', 
        'qty', 'price', 
        'subtotal'
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_id', 'id_order');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id_product');
    }

    public function variant(){
        return $this->belongsTo(ProductVariant::class, 'variant_id', 'id_variant');
    }
}
