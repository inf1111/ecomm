<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

///////

Route::get('/test', function () {
    return view('detail');
});

Route::get('/', [MainController::class, 'showIndex'])->name('show-index');
Route::get('/showProduct/{product_id}', [MainController::class, 'showProduct'])->name('show-product');


// ЛК

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});




