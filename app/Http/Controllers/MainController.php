<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

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
        $order = Order::where(['user_id' => Auth::id(), 'status' => 'filling'])->firstOrFail();

        return view('cart', ['orderItems' => $order->orderItems]);
    }

}

