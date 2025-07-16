<?php

namespace App\Http\Controllers\utilities;

use App\Http\Controllers\Controller;
use App\Models\BusTicketTransaction;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

    private static function getBusTicketTransaction()
    {
        $bus_ticket_transactions = BusTicketTransaction::where("user_id", "=", Auth::id())
            ->with(["busSchedule", "busSchedule.bus", "busSchedule.originStation", "busSchedule.destinationStation"])
            ->get();

        return $bus_ticket_transactions;
    }

    public static function getReport(string $service)
    {
        $reports = null;

        switch ($service) {
            case "bus-ticket":
                $reports = self::getBusTicketTransaction();
                break;
        }

        return $reports;
    }
}
