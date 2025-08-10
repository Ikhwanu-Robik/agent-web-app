<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\BpjsTransaction;
use App\Models\CivilInformation;
use App\Models\PowerTransaction;
use App\Models\BusTicketTransaction;
use App\Models\GameTopUpTransaction;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\FilmTicketTransaction;
use App\Exports\FilmTicketTransactionsExport;

class TransactionReport
{
    public static function getTransactionOfTheMonth()
    {
        $firstDateOfTheMonth = Carbon::now()->startOfMonth();
        $lastDateOfTheMonth = Carbon::now()->lastOfMonth();

        $busTicketTransactions = BusTicketTransaction::where("user_id", "=", Auth::id())
            ->whereBetween("created_at", [$firstDateOfTheMonth, $lastDateOfTheMonth])
            ->get();
        $bpjsTransactions = BpjsTransaction::where("user_id", "=", Auth::id())
            ->whereBetween("created_at", [$firstDateOfTheMonth, $lastDateOfTheMonth])
            ->get();
        $filmTicketTransactions = FilmTicketTransaction::where("user_id", "=", Auth::id())
            ->whereBetween("created_at", [$firstDateOfTheMonth, $lastDateOfTheMonth])
            ->get();
        $gameTopUpTransactions = GameTopUpTransaction::where("user_id", "=", Auth::id())
            ->whereBetween("created_at", [$firstDateOfTheMonth, $lastDateOfTheMonth])
            ->get();
        $powerTopUpTransactions = PowerTransaction::where("user_id", "=", Auth::id())
            ->whereBetween("created_at", [$firstDateOfTheMonth, $lastDateOfTheMonth])
            ->get();

        // relates the service name with each amount of transactions this month
        // with service name as key
        $transactionsCounts = [
            "bus ticket" => $busTicketTransactions->count(),
            "bpjs transaction" => $bpjsTransactions->count(),
            "film ticket" => $filmTicketTransactions->count(),
            "game top up" => $gameTopUpTransactions->count(),
            "power top up" => $powerTopUpTransactions->count()
        ];

        // relates the service name with each amount of transactions this month
        // with amount of transactions as key
        $reverseTransactionCounts = [
            $busTicketTransactions->count() => "bus ticket",
            $bpjsTransactions->count() => "bpjs transaction",
            $filmTicketTransactions->count() => "film ticket",
            $gameTopUpTransactions->count() => "game top up",
            $powerTopUpTransactions->count() => "power top up"
        ];
        
        // get the most transactions of the month
        $topAmount = max($transactionsCounts);
        // get the service name of most transactions of the month
        $topTransactionService = $reverseTransactionCounts[$topAmount];
        $topTransaction = null;

        switch ($topTransactionService) {
            case "bus ticket":
                $topTransaction = $busTicketTransactions;
                break;
            case "bpjs transaction":
                $topTransaction = $bpjsTransactions;
                break;
            case "film ticket":
                $topTransaction = $filmTicketTransactions;
                break;
            case "game top up":
                $topTransaction = $gameTopUpTransactions;
                break;
            case "power top up":
                $topTransaction = $powerTopUpTransactions;
                break;
        }

        $moneySpent = 0;
        foreach ($topTransaction as $record) {
            $moneySpent += $record->total;
        }

        $result = [
            "service" => $topTransactionService,
            "record_count" => count($topTransaction),
            "money_spent" => $moneySpent
        ];

        return $result;
    }

    private static function getBusTicketTransaction()
    {
        $busTicketTransactions = BusTicketTransaction::where("user_id", "=", Auth::id())
            ->with(["busSchedule", "busSchedule.bus", "busSchedule.originStation", "busSchedule.destinationStation"])
            ->get();

        return $busTicketTransactions;
    }

    public function setBpjsReportSession(array $validated)
    {        
        $civilInformation = CivilInformation::where("NIK", "=", $validated["civil_id"])->with(["activeBpjs", "activeBpjs.bpjsClass"])->first();
        $bpjsTransactions = BpjsTransaction::where("civil_information_id", "=", $civilInformation->id)
            ->get();

        session()->put("bpjs_transactions", $bpjsTransactions);
        session()->put("civil_information", $civilInformation);
    }

    public function setPowerTopUpReportSession(array $validated)
    {
        $gameTopUpTransactions = PowerTransaction::where("subscriber_number", "=", $validated["subscriber_number"])->get();
        session()->put("power_top_up_transactions", $gameTopUpTransactions);
    }

    public static function updateBpjsReport()
    {
        $civilInformation = session()->get("civil_information");
        if ($civilInformation) {
            $bpjsTransactions = BpjsTransaction::where("civil_information_id", "=", $civilInformation->id)->get();
    
            session()->put("bpjs_transactions", $bpjsTransactions);
        }
    }

    public static function updatePowerTopUpReport()
    {
        $oldTransactions = session()->get("power_top_up_transactions");
        if ($oldTransactions != null && count($oldTransactions)) {
            $powerTopUpTransactions = PowerTransaction::where("subscriber_number", "=", $oldTransactions[0]->subscriber_number)->get();
    
            session()->put("power_top_up_transactions", $powerTopUpTransactions);
        }
    }

    private static function getFilmTicketTransaction()
    {
        $filmTicketTransactions = FilmTicketTransaction::where("user_id", "=", Auth::id())
            ->with(["cinemaFilm", "cinemaFilm.cinema", "cinemaFilm.film"])
            ->get();

        return $filmTicketTransactions;
    }

    private static function getGameTopupTransaction()
    {
        $gameTopUpTransactions = GameTopUpTransaction::where("user_id", "=", Auth::id())
            ->with(["topUpPackage", "topUpPackage.game"])
            ->get();

        return $gameTopUpTransactions;
    }

    public static function getReport(string $service)
    {
        $reports = null;

        switch ($service) {
            case "bus-ticket":
                $reports = self::getBusTicketTransaction();
                break;
            case "bpjs":
                $bpjsReports = session("bpjs_transactions");
                if ($bpjsReports) {
                    $reports = $bpjsReports;
                    $reports->civil_information = session("civil_information");
                }
                break;
            case "film-ticket":
                $reports = self::getFilmTicketTransaction();
                break;
            case "game-topup":
                $reports = self::getGameTopupTransaction();
                break;
            case "power-top-up":
                $reports = session("power_top_up_transactions");
                break;
        }

        return $reports;
    }

    public static function export(string $service, string $exportType) {
        if ($service == "film-ticket") {
            return Excel::download(new FilmTicketTransactionsExport, "film-ticket-transaction.{$exportType}");
        }

        return null;
    }
}