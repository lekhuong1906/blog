<?php


namespace App\Http\Services;



use App\Models\CartDetail;
use Carbon\Carbon;
use App\Models\ReportSummary;

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
        $cart_details = CartDetail::whereMonth('created_at',$now->month)->get();
        foreach ($cart_details as $cart_detail){
            $products['id'] = $cart_detail->product_id;
            $products['quantity'] = $cart_detail->quantity;
        }
    }
    public function importData($revenue,$order,$receipt){
        $data['revenue'] = $revenue;
        $data['total_order'] = $order;
        $data['total_receipt'] = $receipt;
        return $data;
    }

}
