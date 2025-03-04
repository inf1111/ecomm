<?php

use App\Http\Controllers\AuthController;;
use App\Http\Controllers\MainController;
use App\Livewire\CartTable;
use Illuminate\Support\Facades\Route;

///////

Route::get('/test', function () {
    return view('detail');
});

Route::get('/', [MainController::class, 'showIndex'])->name('show-index');
Route::get('/showProduct/{product_id}', [MainController::class, 'showProduct'])->name('show-product');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::delete('/cart/remove-item', [CartTable::class, 'deleteItem'])->name('cart.remove-item');
    Route::get('/cart', [MainController::class, 'showCart'])->name('show-cart');

    Route::get('/checkout', [MainController::class, 'showCheckout'])->name('show-checkout'); // Страница с формой

    Route::get('/payment/success', [MainController::class, 'showSuccess'])->name('show-success'); // Успешный платеж

    Route::get('/payment/failed', [MainController::class, 'showFailed'])->name('show-failed'); // Ошибка
});


