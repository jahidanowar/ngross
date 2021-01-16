<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HomeController;
use App\Models\Category;
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
Route::resource('category', CategoryController::class)->except(['show', 'create']);
Route::resource('order', OrderController::class)->middleware(['auth:sanctum', 'admin']);;
Route::resource('user', UserController::class)->middleware(['auth:sanctum', 'admin']);
Route::get('getproductlist', [ProductController::class, 'getProducts'])->name('product.list');
Route::get('getuserlist', [userController::class, 'getusers'])->name('user.list');

//Manager Middleware
// Route::group(['prefix' => 'manager', 'name'=>'manager.'], function () {

// });

Route::prefix('manager')->name('manager.')->group(function(){
    Route::resource('user', App\Http\Controllers\manager\UserController::class);
    Route::resource('order', App\Http\Controllers\manager\OrderController::class);
});
