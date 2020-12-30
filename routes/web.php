<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('product', ProductController::class);
// Route::delete('product/delete', [ProductController::class, 'destroy'])->name('product.delete');
Route::resource('order', OrderController::class);
Route::resource('user', UserController::class);
Route::get('getproductlist', [ProductController::class, 'getProducts'])->name('product.list');

