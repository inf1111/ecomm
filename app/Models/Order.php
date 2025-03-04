<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "orders";
    protected $guarded = ['id'];

    protected $fillable = ['status', 'total_price', 'user_id']; // Указываем только те поля, которые разрешены для массового обновления

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Связь с элементами заказа
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}


