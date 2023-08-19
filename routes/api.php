<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReceiptController;
use App\Http\Controllers\Api\SliderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\ImageProductController;
use App\Http\Controllers\Api\ReportSummaryController;

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
Route::post('/register-customer', [AuthController::class, 'createUserCustomer']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::resource('products', ProductController::class)->only('index', 'show');
Route::resource('types', TypeController::class)->except('create', 'edit');
Route::resource('sliders', SliderController::class)->only('index', 'store');

/*--------------------Admin--------------------*/
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('receipts', [ReceiptController::class, 'index']);
    Route::post('products', [ProductController::class, 'store']);

    Route::post('image-products', [ImageProductController::class,'store'])->name('import-images');
    Route::get('image-products',[ImageProductController::class,'show']);
    Route::get('show-dashboard',[ReportSummaryController::class,'showDashboard']);
    Route::post('update-filter',[ReportSummaryController::class,'getFilter']);

});
/*---------------------------------------------*/

/*--------------------Home--------------------*/
Route::middleware(['auth:sanctum', 'customer'])->group(function () {

    Route::get('cart', [CartController::class, 'showCart']);
    Route::post('add-to-cart', [CartController::class, 'addToCart']);
    Route::post('update-cart', [CartController::class, 'updateCart'])->name('update-cart');

    Route::resource('addresses', AddressController::class)->except('create', 'edit');
    Route::resource('receipts', ReceiptController::class)->except('index');
    Route::resource('orders', OrderController::class)->except('create', 'edit', 'destroy');
});

/*---------------------------------------------*/



Route::get('test', function () {

});



