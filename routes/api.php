<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('product', ProductController::class);
Route::resource('category', CategoryController::class);

Route::post('/login', function (Request $request) {

    $user = User::where('email', $request->username)->first();
    if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
        $response = [
            'user' => $user,
            'token' => $user->createToken('logedin')->plainTextToken,
        ];
        return response()->json($response, 200);
    } else {
        $response = [
            'success' => false,
            'message' => 'User name or password is wrong'
        ];
        return response()->json($response, 401);
    }
});


//Guared by Sanctum auth
//Order Route
// Route::get('/order', [OrderController::class, 'index'])->middleware('auth:sanctum');
// Route::get('/order/:id/show', [OrderController::class, 'show'])->middleware('auth:sanctum');
// Route::patch('/order/:id/update', [OrderController::class, 'update'])->middleware('auth:sanctum');
// Route::post('/order/store', [OrderController::class, 'store'])->middleware('auth:sanctum');


Route::resource('/order', OrderController::class)->middleware('auth:sanctum');

Route::get('/profile', function () {
    return auth()->user();
})->middleware("auth:sanctum");


Route::get('/vendor/product', [VendorController::class, 'products'])->middleware("auth:sanctum");
Route::get('/vendor/order', [VendorController::class, 'orders'])->middleware("auth:sanctum");
Route::patch('/vendor/product/{id}', [VendorController::class, 'productUpdate'])->middleware("auth:sanctum");
