<?php

namespace App\Http\Controllers;

use App\Enums\TransactionStatus;
use Illuminate\Http\Request;
use App\Models\BpjsTransaction;
use App\Facades\FlipTransaction;
use App\Models\PowerTransaction;
use App\Http\Controllers\Controller;
use App\Models\BusTicketTransaction;
use App\Models\GameTopUpTransaction;
use App\Models\FilmTicketTransaction;

class FlipCallbackController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            "token" => "required",
            "data" => "required|json"
        ]);

        $data = json_decode($validated["data"]);

        if ($validated['token'] != config('flip.api_token')) {
            return abort(403);
        }

        $flipPaymentResponse = FlipTransaction::getFlipPayment($data->bill_link_id);

        if ($flipPaymentResponse->failed()) {
            abort($flipPaymentResponse->getStatusCode());
        }

        $paymentData = $flipPaymentResponse["data"][0];

        $busTicketTransaction = BusTicketTransaction::where("flip_link_id", "=", $paymentData["link_id"])->first();
        $bpjsTransaction = BpjsTransaction::where("flip_link_id", "=", $paymentData["link_id"])->first();
        $filmTicketTransaction = FilmTicketTransaction::where("flip_link_id", "=", $paymentData["link_id"])->first();
        $gameTopUpTransaction = GameTopUpTransaction::where("flip_link_id", "=", $paymentData["link_id"])->first();
        $powerTransaction = PowerTransaction::where("flip_link_id", "=", $paymentData["link_id"])->first();

        if ($busTicketTransaction) {
            $busTicketTransaction->status = TransactionStatus::from($paymentData["status"]);
            if ($paymentData["status"] == "SUCCESSFUL") {
                $busTicketTransaction->busSchedule
                    ->reduceAvailableTicket($busTicketTransaction->ticket_amount);
            }
            $busTicketTransaction->save();
        } else if ($bpjsTransaction) {
            $bpjsTransaction->status = TransactionStatus::from($paymentData["status"]);
            $bpjsTransaction->save();
        } else if ($filmTicketTransaction) {
            $filmTicketTransaction->status = TransactionStatus::from($paymentData["status"]);
            if ($paymentData["status"] == "SUCCESSFUL") {
                $filmTicketTransaction->CinemaFilm
                    ->updateAvailableSeats(json_decode($filmTicketTransaction->seats_coordinates));
            }
            $filmTicketTransaction->save();
        } else if ($gameTopUpTransaction) {
            $gameTopUpTransaction->status = TransactionStatus::from($paymentData["status"]);
            $gameTopUpTransaction->save();
        } else if ($powerTransaction) {
            $powerTransaction->status = TransactionStatus::from($paymentData["status"]);
            $powerTransaction->save();
        }

        return response("OK");
    }
}
