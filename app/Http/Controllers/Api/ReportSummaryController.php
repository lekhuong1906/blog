<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        $data = $this->service->showDashBoard();
        return new Collection($data);
    }

}
