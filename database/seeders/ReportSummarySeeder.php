<?php

namespace Database\Seeders;

use App\Models\Receipt;
use App\Models\ReportSummary;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReportSummarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $time = Carbon::create(2023,01,01);
        for ($i=0;$i<249;$i++){
            $revenue = random_int(300000,2400000);
            $order = random_int(1,8);
//            $revenue = Receipt::whereDate('created_at','<',$time)->sum('total_amount');
//            $order = Receipt::whereDate('created_at','<',$time)->count('id');
            ReportSummary::create([
                'revenue'=>$revenue,
                'total_order'=>$order,
                'total_receipt'=>$order,
                'created_at'=>$time,
            ]);
            $time->addDay();
        }
    }
}
