<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = "orders";
    protected $guarded = ['id'];

    // Связь с заказом
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Связь с продуктом
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}


