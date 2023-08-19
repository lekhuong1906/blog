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
        $receipts = Receipt::count('id');
        $time = Carbon::create(2023,07,01);
        for ($i=0;$i<$receipts;$i++){
            $revenue = Receipt::whereDate('created_at','<',$time->addDay())->sum('total_amount');
            $order = Receipt::whereDate('created_at','<',$time)->count('id');
            ReportSummary::create([
                'revenue'=>$revenue,
                'total_order'=>$order,
                'total_receipt'=>$order,
                'created_at'=>$time->addDay(),
            ]);
        }
    }
}
