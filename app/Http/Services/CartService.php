<?php


namespace App\Http\Services;


use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function showCart(){
        $cartDetails = User::join('carts','users.id','=','carts.user_id')
            ->join('cart_details','carts.id','=','cart_details.cart_id')
            ->where('users.id',Auth::id())
            ->select('cart_details.*')->get();

        $data = [];
        foreach ($cartDetails as $cartDetail){
            $product = Product::find($cartDetail->product_id);
            $item = [
                'product_name' => $product->product_name,
                'product_price' => $product->product_price,
                'quantity'=> $cartDetail->quantity,
                'total_price'=>$cartDetail->price,
            ];
            array_push($data,$item);
        }
        $cart['item'] = $data;
        $total = Cart::where('user_id',auth()->id())->first();
        $cart['total_price'] = $total->total_price;

        return $cart;
    }
}
