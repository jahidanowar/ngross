<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\User;
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

Route::post('/login', function(Request $request){

    $user = User::where('email', $request->email)->first();
    if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

        return $user->createToken('logedin')->plainTextToken;
    }else{
        $response = [
            'success' => false,
            'message' => 'User name or password is wrong'
        ];
        return json_encode($response);
    }
});

Route::get('/check-auth', function(){
    return Auth::check() ? "Authenticated" : "Not authenticated";
})->middleware('auth:sanctum');
