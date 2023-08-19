<?php

namespace Database\Seeders;

use App\Models\Cart;
use Illuminate\Database\Seeder;
use App\Models\User;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('is_admin',0)->get();
        foreach ($users as $user){
            Cart::create([
                'user_id' => $user->id,
                'total_price'=>0,
            ]);
        }
    }
}
