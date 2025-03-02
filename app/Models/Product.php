<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";
    protected $guarded = ['id'];

    // Связь с категорией
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Связь с элементами заказа
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}


