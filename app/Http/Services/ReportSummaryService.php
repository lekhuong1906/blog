<?php


namespace App\Http\Services;



use App\Models\CartDetail;
use App\Models\Order;
use Carbon\Carbon;
use App\Models\ReportSummary;
use Illuminate\Support\Facades\DB;

class ReportSummaryService
{
    protected $data = array();

    public function showDashBoard($filter){
        $value = $this->getReport($filter);
        return $value;
    }

    public function getReport($filter){
        $now = Carbon::now();
        if ($filter == 0 || $filter == null){
            $revenue = ReportSummary::whereYear('created_at',$now->year)->sum('revenue');
            $total_order = ReportSummary::whereYear('created_at',$now->year)->sum('total_order');
            $total_receipt = ReportSummary::whereYear('created_at',$now->year)->sum('total_receipt');
        } else if ($filter == 1){
            $revenue = ReportSummary::whereMonth('created_at',$now->month)->sum('revenue');
            $total_order = ReportSummary::whereMonth('created_at',$now->month)->sum('total_order');
            $total_receipt = ReportSummary::whereMonth('created_at',$now->month)->sum('total_receipt');
        }else if ($filter == 2) {
            $revenue = ReportSummary::whereDate('created_at',$now)->sum('revenue');
            $total_order = ReportSummary::whereDate('created_at',$now)->sum('total_order');
            $total_receipt = ReportSummary::whereDate('created_at',$now)->sum('total_receipt');
        }

        $data = $this->importData($revenue,$total_order,$total_receipt);
        return $data;
    }

    public function getBestSellingProduct(){
        $now = new Carbon();

        $bestSellingProduct = Order::select('product_id',DB::raw('SUM(quantity) as total_quantity'))
            ->whereMonth('created_at',$now->month)
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->get();

         dd (json_decode(json_encode($bestSellingProduct),true));
    }
    public function importData($revenue,$order,$receipt){
        $data['revenue'] = $revenue;
        $data['total_order'] = $order;
        $data['total_receipt'] = $receipt;
//        $data['bestselling_product'] = $bestselling_products;
        return $data;
    }

}
