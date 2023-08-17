<?php

namespace Database\Seeders;

use App\Models\CartDetail;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CartDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0;$i < 50;$i++) {
            $product_id = random_int(1, 29);
            $quantity = random_int(1, 5);
            $product = Product::find($product_id);
            $product_price = $product->product_price;

            CartDetail::create([
                'cart_id' => random_int(1, 5),
                'product_id' => $product_id,
                'quantity' => $quantity,
                'price' => $quantity * $product_price,
                'status'=>1
            ]);
        }
    }
}
