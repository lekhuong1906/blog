<?php


namespace App\Http\Services;



use Carbon\Carbon;
use App\Models\ReportSummary;

class ReportSummaryService
{
    protected $data = array();

    public function showDashBoard($request){
        $filter = $request->filter;
        $this->getReport($filter);
        return $this->data;
    }

    public function getReport($filter){
        $now = Carbon::now();
        switch ($filter){
            case 'month':
                $revenue = ReportSummary::whereMonth('created_at',$now->month)->sum('revenue');
                $total_order = ReportSummary::whereMonth('created_at',$now->month)->sum('total_order');
                $total_receipt = ReportSummary::whereMonth('created_at',$now->month)->sum('total_receipt');
                $this->importData($revenue,$total_order,$total_receipt);
                break;
            case 'day':
                $revenue = ReportSummary::whereDate('created_at',$now->day)->sum('revenue');
                $total_order = ReportSummary::whereDate('created_at',$now->day)->sum('total_order');
                $total_receipt = ReportSummary::whereDate('created_at',$now->day)->sum('total_receipt');
                $this->importData($revenue,$total_order,$total_receipt);
                break;
            default:
                $revenue = ReportSummary::whereYear('created_at',$now->year)->sum('revenue');
                $total_order = ReportSummary::whereYear('created_at',$now->year)->sum('total_order');
                $total_receipt = ReportSummary::whereYear('created_at',$now->year)->sum('total_receipt');
                $this->importData($revenue,$total_order,$total_receipt);
        }
    }
    public function importData($revenue,$order,$receipt){
        $this->data['revenue'] = $revenue;
        $this->data['total_order'] = $order;
        $this->data['total_receipt'] = $receipt;
        return $this->data;
    }

}
