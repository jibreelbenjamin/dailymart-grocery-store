<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";
    protected $primaryKey = 'id_order';
    protected $fillable = [
        'user_id',
        'total',
        'payment',
        'shipping_address',
        'tracking_number',
        'status'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    public function items(){
        return $this->hasMany(OrderItem::class, 'order_id', 'id_order');
    }
}
