<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Services\CartService;


class CartController extends Controller
{
    protected $service;
    public function __construct(CartService $cartService)
    {
        $this->service = $cartService;
    }

    public function showCart()
    {
        return new Collection($this->service->showCart());
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->productId);
        $userId = Auth::id();
        $quantity = $request->quantity;
        $cart = Cart::where('user_id',$userId)->first();

        $cartDetail = CartDetail::where('cart_id',$cart->id)->where('product_id',$product->id)->first();

        try {
            if (!$cartDetail){
                # Import new item into CartDetail
                CartDetail::create([
                    'cart_id'=>$cart->id,
                    'product_id'=>$product->id,
                    'quantity'=>$quantity,
                    'price'=> $quantity * $product->product_price
                ]);

                # Update Cart(total_price)
                $total = CartDetail::where('cart_id',$cart->id)->sum('price');
                $cart->total_price = $total;
                $cart->save();

            } else {
                # Get new_quantity and new_price
                $newQuantity = $cartDetail->quantity +=$quantity;
                $newPrice = $newQuantity * $product->product_price;

                # Update new_quantity and new_price
                $cartDetail->quantity = $newQuantity;
                $cartDetail->price = $newPrice;
                $cartDetail->save();

                # Update Cart(total_price)
                $total = CartDetail::where('cart_id',$cart->id)->sum('price');
                $cart->total_price = $total;
                $cart->save();
            }

            return \response()->json([
                'message'=>'Success',
            ]);
        } catch (\Exception $e){
            return \response()->json([
                'message'=>$e->getMessage(),
            ]);
        }
    }

}
