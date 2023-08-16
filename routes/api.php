<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReceiptController;
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
    Route::get('receipts',[ReceiptController::class,'index']);
});


Route::middleware(['auth:sanctum','customer'])->group(function () {

    Route::get('cart',[CartController::class,'showCart']);
    Route::post('add-to-cart',[CartController::class,'addToCart']);
    Route::post('update-cart',[CartController::class,'updateCart']);
    Route::resource('addresses',AddressController::class)->except('create','edit');
    Route::resource('receipts',ReceiptController::class)->except('index');
    Route::resource('orders',OrderController::class)->except('create','edit','destroy');
});


Route::resource('image-products', ImageProductController::class)->only('store', 'show');
Route::resource('products', ProductController::class)->only('index', 'store', 'show');
Route::resource('types', TypeController::class)->except('create', 'edit');
Route::resource('sliders', SliderController::class)->only('index', 'store');

/*use App\Models\ImageProduct;
Route::get('test',function (){

   $images = ImageProduct::get();
    foreach ($images as $image){
        $image_links = explode(',',$image->image_link);
        $a = [];
        foreach ($image_links as $image_link){
            $head = explode('blog.test/',$image_link);
            $a[] = $head[0].'blog.test:8080/'.$head[1];

        }
        $image->image_link = implode(',',$a);
        $image->save();
    }

    return response()->json([
        'message'=>'Xong roài đóa anh troai',
    ]);
});*/


