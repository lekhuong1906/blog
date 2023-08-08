<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\SliderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\ImageProductController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




Route::post('/register', [AuthController::class, 'createUser']);
Route::post('/login', [AuthController::class, 'loginUser'])->name('login');

Route::middleware(['auth:sanctum'])->group(function (){

});

Route::get('cart',[CartController::class,'showCart']);
Route::post('add-to-cart',[CartController::class,'addToCart']);
Route::resource('image-products',ImageProductController::class)->only('store','show');
Route::resource('products',ProductController::class)->only('index','store','show');
Route::resource('types',TypeController::class)->except('create','edit');
Route::resource('sliders',SliderController::class)->only('index','store');






