<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
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

            $phone = 0;
            for ($i=1;$i<10;$i++)
                $phone.=random_int(1,9);

            Address::create([
                'user_id'=>$user->id,
                'receiver_name'=>$user->name,
                'contact_number'=>$phone,
                'specific_address'=>'1/12 Street 29, District 2',
            ]);
        }

    }
}
