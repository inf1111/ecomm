<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    protected $guarded = ['id'];
    public $timestamps = false;

    // Связь с продуктами
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}


