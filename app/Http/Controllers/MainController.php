<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\PaymentIntent;
use Stripe\Stripe;

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

    public function showCheckout()
    {
        // Находим заказ с продуктами, которые пользователь собирается оплатить
        $order = Order::where('user_id', Auth::id())->where('status', 'filling')->firstOrFail();

        // Инициализируем Stripe с секретным ключом
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Создаем PaymentIntent для заказа
        $paymentIntent = PaymentIntent::create([
            'amount' => $order->total_price * 100, // сумма в копейках (Stripe работает в копейках)
            'currency' => 'rub',
            'automatic_payment_methods' => ['enabled' => true], // Включаем автоматические методы оплаты
        ]);

        // Возвращаем view с информацией для фронта
        return view('checkout', [
            'order' => $order,
            'clientSecret' => $paymentIntent->client_secret, // передаем client_secret для фронта
            //'paymentIntentId' => $paymentIntent->id, // передаем ID PaymentIntent
            'orderItems' => $order->orderItems
        ]);
    }

    // Страница успеха
    public function showSuccess(Request $request)
    {
        $order = Order::where('user_id', Auth::id())->where('status', 'filling')->first();

        if ($order) {
            $order->status = 'success';
            $order->save();
        }

        return view('payment-success', ['order' => $order]);
    }

    // Страница неуспешной оплаты
    public function showFailed(Request $request)
    {
        $order = Order::where('user_id', Auth::id())->where('status', 'filling')->first();

        return view('payment-failed', ['order' => $order]);

    }

}

