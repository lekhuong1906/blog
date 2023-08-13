<?php


namespace App\Http\Services;


use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function showCart()
    {
        $cartDetails = User::join('carts', 'users.id', '=', 'carts.user_id')
            ->join('cart_details', 'carts.id', '=', 'cart_details.cart_id')
            ->where('users.id', \auth()->id())
            ->select('cart_details.*')->get();

        try {
            $data = [];
            foreach ($cartDetails as $cartDetail) {
                $product = Product::find($cartDetail->product_id);
                $item = [
                    'product_name' => $product->product_name,
                    'product_price' => $product->product_price,
                    'quantity' => $cartDetail->quantity,
                    'total_price' => $cartDetail->price,
                ];
                array_push($data, $item);
            }
            $cart['item'] = $data;
            $total = Cart::where('user_id', \auth()->id())->first();
            $cart['total'] = $total->total_price;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage(),]);
        }


        return $cart;
    }

    public function getCart($user_id)
    {
        $cart = Cart::where('user_id', $user_id)->first();
        if (!$cart) {
            #Add new cart
            Cart::insert([
                'user_id' => $user_id,
                'total_price' => 0,
            ]);
            $cart = Cart::where('user_id', $user_id)->first();
        }
        return $cart;
    }

    public function addCartDetail($cart, $product, $quantity)
    {
        $cart_detail = CartDetail::where('cart_id', $cart->id)->where('product_id', $product->id)->first();
        if (!$cart_detail) {

            # Import new item into CartDetail
            CartDetail::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $quantity * $product->product_price
            ]);

            $this->updatePriceCart($cart->id);

        } else {

            # Check Cart Status
            if ($cart_detail->status == 0){
                $cart_detail->status = 1;
                $cart_detail->save();
            }

            # Get new_quantity and new_price
            $newQuantity = $cart_detail->quantity += $quantity;
            $newPrice = $newQuantity * $product->product_price;

            # Update new_quantity and new_price
            $cart_detail->quantity = $newQuantity;
            $cart_detail->price = $newPrice;
            $cart_detail->save();

            # Update Cart(total_price)
            $this->updatePriceCart($cart->id);
        }
    }

    public function cartDetailUpdate($cart_id, $product_id, $quantity)
    {
        $product = Product::where('id', $product_id)->first();
        $cart_detail = CartDetail::where('cart_id', $cart_id)->where('product_id', $product_id)->first();

        $cart_detail->quantity = $quantity;
        $cart_detail->price = $product->product_price * $quantity;

        if ($quantity == 0) //Update Status Quantity If Quantity = 0
            $cart_detail->status = 0;

        $cart_detail->save();
    }

    public function updatePriceCart($cart_id)
    {
        # Update Cart(total_price)
        $total = CartDetail::where('cart_id', $cart_id)->where('status', 1)->sum('price');
        $cart = Cart::where('id', $cart_id)->first();
        $cart->total_price = $total;
        $cart->save();
    }
}
