<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\CartDetail;
use App\Models\Receipt;
use Carbon\Carbon;
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
        $time = Carbon::create(2023,07,01);
        foreach ($cart_details as $cart_detail){
            $user_id = $cart_detail->cart->user_id;
            $address_id = Address::where('user_id',$user_id)->inRandomOrder()->value('id');
            $total_amount = $cart_detail->price;
            Receipt::create([
                'user_id'=>$user_id,
                'address_id'=>$address_id,
                'total_amount'=>$total_amount,
                'status'=>0,
                'created_at'=>$time->addDay(),
            ]);
        }
    }
}
