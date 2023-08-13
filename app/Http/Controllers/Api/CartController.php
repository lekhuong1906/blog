<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\CartService;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    protected $service;

    public function __construct(CartService $cartService)
    {
        $this->service = $cartService;
    }

    public function showCart()
    {

        return json_decode(json_encode($this->service->showCart()), true);
    }

    public function addToCart(Request $request)
    {

        $product = Product::find($request->productId);
        $user_id = auth()->id();
        $quantity = $request->quantity;

        $cart = $this->service->getCart($user_id);
        $this->service->addCartDetail($cart, $product, $quantity);

        return response()->json([
            'message' => 'Add to Cart Success',
        ]);
    }

    public function updateCart(Request $request)
    {
        try {
            $product_id = $request->product_id;
            $quantity = $request->quantity;
            $cart = Cart::where('user_id', \auth()->id())->first();

            $this->service->cartDetailUpdate($cart->id, $product_id, $quantity);
            $this->service->updatePriceCart($cart->id);

        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ]);
        }

        return response()->json([
            'message' => 'Success',
        ]);
    }


}
