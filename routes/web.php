<?php

use App\Http\Controllers\MainController;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/test', function () {
    return view('detail');
});

Route::get('/', [MainController::class, 'showIndex'])->name('show-index');

Route::get('/showProduct/{product_id}', [MainController::class, 'showProduct'])->name('show-product');
