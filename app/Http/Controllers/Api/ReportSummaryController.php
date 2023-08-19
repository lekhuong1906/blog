<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\ReportSummary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Services\ReportSummaryService;

class ReportSummaryController extends Controller
{
    protected $service;
    public function __construct(ReportSummaryService $reportSummaryService)
    {
        $this->service = $reportSummaryService;
    }

    public function showDashboard(Request $request){
        $receipts = Receipt::count('id');
        $time = Carbon::create(2023,07,01);
        for ($i=0;$i<$receipts;$i++){
            $revenue = Receipt::whereDate('created_at','<',$time->addDay())->count('id');
            $order = Receipt::whereDate('created_at','<',$time)->count('id');
            $data['revenue'][] = $revenue;
            $data['order'][] = $order;
        }
        dd($data);
    }

}
