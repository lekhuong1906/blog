<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\CartDetail;
use App\Models\Receipt;
use Illuminate\Database\Seeder;

class ReceiptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cart_details = CartDetail::get();
        foreach ($cart_details as $cart_detail){
            $user_id = $cart_detail->cart->user_id;
            $address_id = Address::where('user_id',$user_id)->inRandomOrder()->value('id');
            $total_amount = $cart_detail->price;
            Receipt::create([
                'user_id'=>$user_id,
                'address_id'=>$address_id,
                'total_amount'=>$total_amount,
                'status'=>random_int(0,1),
            ]);
        }
    }
}
