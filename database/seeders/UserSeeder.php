<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make(123456);
        for ($i=1;$i<21;$i++){
            $name = 'User '.$i;
            $email = 'user_'.$i.'@gmail.com';
            if ($i==1)
                $is_admin = 1;
            else
                $is_admin = 0;
            User::create([
                'name'=>$name,
                'email'=>$email,
                'password'=>$password,
                'is_admin'=>$is_admin,
                'created_at'=>Carbon::now(),
            ]);
        }
    }
}
