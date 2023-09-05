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
Route::post('/register-customer', [AuthController::class, 'createUserCustomer']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

# HOME
Route::get('sliders', [SliderController::class, 'index']);
Route::resource('products', ProductController::class)->only('index', 'show');
Route::resource('types', TypeController::class)->except('create', 'edit');


/*--------------------Admin--------------------*/
Route::middleware(['auth:sanctum', 'admin'])->group(function () {


    # Manage Dashboard
    Route::get('show-dashboard', [ReportSummaryController::class, 'showDashboard']);
    Route::post('update-filter', [ReportSummaryController::class, 'getFilter']);

    # Manage Banner
    Route::post('sliders', [SliderController::class, 'store']);

    # Manage Receipt & Order
    Route::resource('receipts', ReceiptController::class)->except('edit', 'create');

    # Manage User
    Route::resource('users', UserController::class)->except('create');

    # Manage Product
    Route::resource('products', ProductController::class)->only('store', 'update', 'destroy');

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
    Route::post('receipts', [ReceiptController::class, 'store']);

    Route::get('all-receipt-customer', [ReceiptController::class, 'allReceiptCustomer']);
    Route::get('receipt-detail/{id}', [ReceiptController::class, 'show']);

});

/*---------------------------------------------*/

use App\Mail\MailSuccess;
use Illuminate\Support\Facades\Mail;
use App\Models\Receipt;

Route::get('test', function () {


    try {
        $data = [
            'user_id' => 4,
            'user_name' => 'Abc',
            'email' => 'user_4@gmail.com',
            'order_detail' => [
                [
                    'order_id' => 1,
                    'product_name' => 'Backpack',
                    'quantity' => 1,
                    'unit_price' => 370000],
                [
                    'order_id' => 2,
                    'product_name' => 'Wallet',
                    'quantity' => 1,
                    'unit_price' => 34000
                ]
            ],
            'receipt_id'=>1,
            'receiver_name'=>'Nguyen Van A',
            'contact_number'=>'123456',
            'specific_address' => '12 No Way',
            'receipt_status' => 1,
            'total_amount' => 960000,
            'created_at' => '2023-08-22T14:02:06.000000Z'
        ];

//        $data = json_decode(json_encode($data), true);

        Mail::to('lekhuong190602@gmail.com')->send(new MailSuccess($data));

        return 123;
    } catch (Exception $e) {
        return $e->getMessage();
    }

});



