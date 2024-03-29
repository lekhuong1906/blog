<?php


namespace App\Http\Services;

use App\Models\ImageProduct;
use App\Models\Order;
use App\Models\Product;


class OrderService extends CartService
{

    public function addNewOrder($cart,$receipt_id){

        $cart_details = $cart->cartDetail;

        foreach ($cart_details as $cart_detail){

            $product_id = $cart_detail->product_id;
            $quantity = $cart_detail->quantity;

            $this->addNewOrderDetail($receipt_id,$product_id,$quantity);

            $cart_detail->delete();

            $this->updateProductStock($product_id,$quantity);
        }

        $this->updatePriceCart($cart->id);

    }

    public function updateProductStock($product_id,$quantity){
        $product = Product::find($product_id);
        $product->product_stock -= $quantity;
        $product->save();
    }




    public function addNewOrderDetail($receipt_id,$product_id,$quantity){

        $product = Product::find($product_id);

        $new_order_detail = new Order();
        $new_order_detail->receipt_id = $receipt_id;
        $new_order_detail->product_id = $product_id;
        $new_order_detail->quantity = $quantity;
        $new_order_detail->total = $quantity*($product->product_price);
        $new_order_detail->save();
    }

    public function getProductDetail($receipt_id){
        $data = [];
        $orders = Order::where('receipt_id',$receipt_id)->get();
        foreach ($orders as $order){

            $product = Product::find($order->product_id);

            $product_detail['order_id'] = $order->id;
            $product_detail['product_name'] = $product->product_name;
            $product_detail['quantity'] = $order->quantity;
            $product_detail['unit_price'] = $product->product_price;
            $product_detail['image'] = $this->getImage($product->id);


            array_push($data,$product_detail);
        }
        return $data;
    }


}
