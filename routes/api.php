<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\SliderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\ImageProductController;

use Illuminate\Http\Request;

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



Route::post('/register-admin', [AuthController::class, 'createUserAdmin']);
Route::post('/register-customer',[AuthController::class,'createUserCustomer']);
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::middleware(['auth:sanctum','admin'])->group(function () {
    // Các route của trang admin
});


Route::middleware(['auth:sanctum','customer'])->group(function () {

    Route::get('cart',[CartController::class,'showCart']);
    Route::post('add-to-cart',[CartController::class,'addToCart']);
    Route::post('update-cart',[CartController::class,'updateCart']);

});


Route::resource('image-products', ImageProductController::class)->only('store', 'show');
Route::resource('products', ProductController::class)->only('index', 'store', 'show');
Route::resource('types', TypeController::class)->except('create', 'edit');
Route::resource('sliders', SliderController::class)->only('index', 'store');







