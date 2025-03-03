<?php

namespace App\Http\Controllers;

use App\Models\Product;

class MainController extends Controller
{

    public function showIndex()
    {
        $products = Product::orderBy('created_at', 'desc')->get();

        return view('index', ['products' => $products]);
    }

    public function showProduct($product_id)
    {
        $product = Product::where('id', $product_id)->firstOrFail();

        return view("product", ['product' => $product]);
    }

    public function showCart()
    {
        return view('cart');
    }

}

