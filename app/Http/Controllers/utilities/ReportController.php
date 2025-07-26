<?php

namespace App\Http\Controllers\utilities;

use App\Models\FilmTicketTransaction;
use App\Models\GameTopUpTransaction;
use App\Models\PowerTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BpjsTransaction;
use App\Models\CivilInformation;
use App\Http\Controllers\Controller;
use App\Models\BusTicketTransaction;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public static function getTransactionOfTheMonth()
    {
        $first_date_of_the_month = Carbon::now()->startOfMonth();
        $last_date_of_the_month = Carbon::now()->lastOfMonth();

        $bus_ticket_transactions = BusTicketTransaction::where("user_id", "=", Auth::id())
            ->whereBetween("created_at", [$first_date_of_the_month, $last_date_of_the_month])
            ->get();
        $bpjs_transactions = BpjsTransaction::where("user_id", "=", Auth::id())
            ->whereBetween("created_at", [$first_date_of_the_month, $last_date_of_the_month])
            ->get();
        $film_ticket_transactions = FilmTicketTransaction::where("user_id", "=", Auth::id())
            ->whereBetween("created_at", [$first_date_of_the_month, $last_date_of_the_month])
            ->get();
        $game_top_up_transactions = GameTopUpTransaction::where("user_id", "=", Auth::id())
            ->whereBetween("created_at", [$first_date_of_the_month, $last_date_of_the_month])
            ->get();
        $power_top_up_transactions = PowerTransaction::where("user_id", "=", Auth::id())
            ->whereBetween("created_at", [$first_date_of_the_month, $last_date_of_the_month])
            ->get();

        $transactions_counts = [
            "bus ticket" => $bus_ticket_transactions->count(),
            "bpjs transaction" => $bpjs_transactions->count(),
            "film ticket" => $film_ticket_transactions->count(),
            "game top up" => $game_top_up_transactions->count(),
            "power top up" => $power_top_up_transactions->count()
        ];

        $reverse_transaction_counts = [
            $bus_ticket_transactions->count() => "bus ticket",
            $bpjs_transactions->count() => "bpjs transaction",
            $film_ticket_transactions->count() => "film ticket",
            $game_top_up_transactions->count() => "game top up",
            $power_top_up_transactions->count() => "power top up"
        ];
        
        $top_transaction_service = $reverse_transaction_counts[max($transactions_counts)];
        $top_transaction = null;

        switch ($top_transaction_service) {
            case "bus ticket":
                $top_transaction = $bus_ticket_transactions;
                break;
            case "bpjs transaction":
                $top_transaction = $bpjs_transactions;
                break;
            case "film ticket":
                $top_transaction = $film_ticket_transactions;
                break;
            case "game top up":
                $top_transaction = $game_top_up_transactions;
                break;
            case "power top up":
                $top_transaction = $power_top_up_transactions;
                break;
        }

        $money_spent = 0;
        foreach ($top_transaction as $record) {
            $money_spent += $record->total;
        }

        $result = [
            "service" => $top_transaction_service,
            "record_count" => count($top_transaction),
            "money_spent" => $money_spent
        ];

        return $result;
    }

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

    public function getPowerTopUpReport(Request $request)
    {
        $validated = $request->validate([
            "subscriber_number" => "required|numeric"
        ]);

        $game_top_up_transactions = PowerTransaction::where("subscriber_number", "=", $validated["subscriber_number"])->get();
        session()->put("power_top_up_transactions", $game_top_up_transactions);

        return redirect("/report?service=power-top-up");
    }

    public static function updateBpjsReport()
    {
        $civil_information = session()->get("civil_information");
        $bpjs_transactions = BpjsTransaction::where("civil_information_id", "=", $civil_information->id)->get();

        session()->put("bpjs_transactions", $bpjs_transactions);
    }

    public static function updatePowerTopUpReport()
    {
        $old_transactions = session()->get("power_top_up_transactions");
        $power_top_up_transactions = PowerTransaction::where("subscriber_number", "=", $old_transactions[0]->subscriber_number)->get();

        session()->put("power_top_up_transactions", $power_top_up_transactions);
    }

    private static function getFilmTicketTransaction()
    {
        $film_ticket_transactions = FilmTicketTransaction::where("user_id", "=", Auth::id())
            ->with(["cinemaFilm", "cinemaFilm.cinema", "cinemaFilm.film"])
            ->get();

        return $film_ticket_transactions;
    }

    private static function getGameTopupTransaction()
    {
        $game_topup_transactions = GameTopUpTransaction::where("user_id", "=", Auth::id())
            ->with(["topUpPackage", "topUpPackage.game"])
            ->get();

        return $game_topup_transactions;
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
            case "game-topup":
                $reports = self::getGameTopupTransaction();
                break;
            case "power-top-up":
                $reports = session()->get("power_top_up_transactions");
                break;
        }

        return $reports;
    }
}
