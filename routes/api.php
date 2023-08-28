<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ReceiptController;
use App\Http\Controllers\Api\SliderController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\ReportSummaryController;
use App\Http\Controllers\Api\UserController;

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

# Manage Login and Register
Route::post('/register-admin', [AuthController::class, 'createUserAdmin']);
Route::post('/register-customer', [AuthController::class, 'createUserCustomer']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

# HOME
Route::get('sliders',[SliderController::class,'index']);
Route::resource('products', ProductController::class)->only('index', 'show');
Route::resource('types', TypeController::class)->except('create', 'edit');



/*--------------------Admin--------------------*/
Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    # Manage Dashboard
    Route::get('show-dashboard', [ReportSummaryController::class, 'showDashboard']);
    Route::post('update-filter', [ReportSummaryController::class, 'getFilter']);

    # Manage Banner
    Route::post('sliders',[SliderController::class,'store']);

    # Manage Receipt & Order
    Route::get('receipts', [ReceiptController::class, 'index']);
    Route::get('receipts/{id}',[ReceiptController::class, 'show']);

    Route::resource('users',UserController::class)->except('create','destroy');

    # Manage Product
    Route::resource('products', ProductController::class)->only('store', 'update','destroy');

});
/*---------------------------------------------*/

/*--------------------Home--------------------*/
Route::middleware(['auth:sanctum', 'customer'])->group(function () {

    # Manage Cart
    Route::get('cart', [CartController::class, 'showCart']);
    Route::post('add-to-cart', [CartController::class, 'addToCart']);
    Route::post('update-cart', [CartController::class, 'updateCart'])->name('update-cart');
    Route::delete('delete-item/{id}', [CartController::class, 'deleteCartItem']);

    # Order
    Route::post('receipts',[ReceiptController::class,'store']);

});

/*---------------------------------------------*/



Route::get('test', function () {

});



