<?php


namespace App\Http\Services;


use App\Models\CartDetail;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\ReportSummary;
use Illuminate\Support\Facades\DB;

class ReportSummaryService
{
    public function showDashBoard(){
        $summary = $this->getReport();
        $chart = $this->dataChart();

        $data = [
            'summary' => $summary,
            'chart' => $chart,
        ];
        return $data;
    }

    public function getReport()
    {
        $now = Carbon::now();

        $revenue = ReportSummary::whereYear('created_at', $now->year)->sum('revenue');
        $total_order = ReportSummary::whereYear('created_at', $now->year)->sum('total_order');
        $total_receipt = ReportSummary::whereYear('created_at', $now->year)->sum('total_receipt');

        $data = array();
        $data['revenue'] = $revenue;
        $data['total_order'] = $total_order;
        $data['total_receipt'] = $total_receipt;

        return $data;
    }

    public function dataChart()
    {
        $data = array();
        $now = Carbon::now();
        for ($i=1;$i<13;$i++){

            $data[$i] =  ReportSummary::whereMonth('created_at',$i)->sum('revenue');
        }

        return $data;
    }

    public function getBestSellingProduct()
    {
        $now = new Carbon();

        $bestSellingProduct = Order::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
            ->whereMonth('created_at', $now->month)
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->get();

        dd(json_decode(json_encode($bestSellingProduct), true));
    }


}
