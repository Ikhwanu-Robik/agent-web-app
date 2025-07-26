<?php

namespace App\Http\Controllers\views;

use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\utilities\ReportController;

class GeneralViewController extends Controller
{
    public function showLoginForm()
    {
        return view("auth.login");
    }

    public function showRegisterForm()
    {
        return view("auth.register");
    }

    public function home()
    {
        $transaction_of_the_month = ReportController::getTransactionOfTheMonth();
        
        return view("home", ["transaction_of_the_month" => $transaction_of_the_month]);
    }

    public function vouchers()
    {
        $vouchers = Voucher::where("user_id", "=", Auth::id())->get();

        return view("vouchers", ["vouchers" => $vouchers]);
    }

    public function report(Request $request)
    {
        $service = $request->query("service") ? $request->query("service") : "";
        $reports = ReportController::getReport($service);

        return view("report", ["service" => $service, "reports" => $reports]);
    }

    public function master()
    {
        return view("master.master");
    }
}