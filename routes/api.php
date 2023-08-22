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

    Route::resource('products', ProductController::class)->only('store', 'update');


    Route::get('show-dashboard',[ReportSummaryController::class,'showDashboard']);
    Route::post('update-filter',[ReportSummaryController::class,'getFilter']);

});
/*---------------------------------------------*/

/*--------------------Home--------------------*/
Route::middleware(['auth:sanctum', 'customer'])->group(function () {

    Route::get('cart', [CartController::class, 'showCart']);
    Route::post('add-to-cart', [CartController::class, 'addToCart']);
    Route::post('update-cart', [CartController::class, 'updateCart'])->name('update-cart');
    Route::delete('delete-item/{id}',[CartController::class,'deleteCartItem']);

    Route::resource('receipts', ReceiptController::class)->except('index');
});

/*---------------------------------------------*/



Route::get('test', function () {
    $descriptions = \App\Models\ProductDescription::all();
    foreach ($descriptions as $description ){
        $description->product_id = $description->id;
        $description->save();
    }
    return response()->json(['message'=>'Successfully']);
});



