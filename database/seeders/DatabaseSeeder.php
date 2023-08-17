<?php

namespace Database\Seeders;

use App\Http\Services\ReceiptService;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Receipt;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CartDetailSeeder::class,
            ReceiptSeeder::class,
        ]);
    }
}
