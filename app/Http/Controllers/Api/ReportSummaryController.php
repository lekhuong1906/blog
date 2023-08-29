<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\ReportSummaryService;
use Illuminate\Support\Collection;

class ReportSummaryController extends Controller
{
    protected $service;
    public function __construct(ReportSummaryService $reportSummaryService)
    {
        $this->service = $reportSummaryService;
    }

    public function showDashboard(){
        $this->service->getBestSellingProduct();
        $filter = 0; // Set filter default = Year
        $data = $this->service->getReport($filter);
        return new Collection($data);
    }

    public function getFilter(Request $request){
        $filter = $request->filter;
        $data = $this->service->getReport($filter);
        return ($data);

    }

}
