<?php

namespace App\Http\Controllers\utilities;

use App\Models\FilmTicketTransaction;
use Illuminate\Http\Request;
use App\Models\BpjsTransaction;
use App\Models\CivilInformation;
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

    public function getBpjsReport(Request $request)
    {
        $validated = $request->validate([
            "civil_id" => "required|exists:civil_informations,NIK"
        ]);

        $civil_information = CivilInformation::where("NIK", "=", $validated["civil_id"])->with(["activeBpjs", "activeBpjs.bpjsClass"])->first();
        $bpjs_transactions = BpjsTransaction::where("civil_information_id", "=", $civil_information->id)
            ->get();

        session()->put("bpjs_transactions", $bpjs_transactions);
        session()->put("civil_information", $civil_information);

        return redirect("/report?service=bpjs");
    }

    private static function getFilmTicketTransaction()
    {
        $film_ticket_transactions = FilmTicketTransaction::where("user_id", "=", Auth::id())
            ->with(["cinemaFilm", "cinemaFilm.cinema", "cinemaFilm.film"])
            ->get();

        return $film_ticket_transactions;
    }

    public static function getReport(string $service)
    {
        $reports = null;

        switch ($service) {
            case "bus-ticket":
                $reports = self::getBusTicketTransaction();
                break;
            case "bpjs":
                $bpjsReports = session()->get("bpjs_transactions");
                if ($bpjsReports) {
                    $reports = $bpjsReports;
                    $reports->civil_information = session()->get("civil_information");
                }
                break;
            case "film-ticket":
                $reports = self::getFilmTicketTransaction();
                break;
        }

        return $reports;
    }
}
