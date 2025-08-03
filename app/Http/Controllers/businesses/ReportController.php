<?php

namespace App\Http\Controllers\Businesses;

use App\Facades\TransactionReport;
use App\Http\Requests\GetBpjsReportRequest;
use App\Http\Requests\GetPowerTopUpReportRequest;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function getBpjsReport(GetBpjsReportRequest $getBpjsReportRequest) {
        TransactionReport::setBpjsReportSession($getBpjsReportRequest->validated());

        return redirect("/report?service=bpjs");;
    }

    public function getPowerTopUpReport(GetPowerTopUpReportRequest $getPowerTopUpReportRequest) {
        TransactionReport::setPowerTopUpReportSession($getPowerTopUpReportRequest->validated());

        return redirect("/report?service=power-top-up");
    }
}