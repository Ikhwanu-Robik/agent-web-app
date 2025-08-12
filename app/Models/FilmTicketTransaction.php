<?php

namespace App\Models;

use App\Enums\FlipStep;
use App\Models\Voucher;
use App\Models\CinemaFilm;
use App\Enums\FlipBillType;
use App\Facades\FlipTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class FilmTicketTransaction extends Model
{
    protected $table = "film_ticket_transactions";

    protected $fillable = [
        "cinema_film_id",
        "seats_coordinates",
        "total",
        "method",
        "status",
        "flip_link_id"
    ];

    public function CinemaFilm()
    {
        return $this->belongsTo(CinemaFilm::class);
    }

    public static function createOrder(array $validated)
    {
        $cinemaFilm = CinemaFilm::with("cinema", "film")->find($validated["cinema_film_id"]);

        $transactionAttributes = [
            "cinema_film_id" => $cinemaFilm->id,
            "seats_coordinates" => json_encode($validated["seat_coordinates"]),
            "total" => $cinemaFilm->ticket_price * count($validated["seat_coordinates"]),
        ];
        $filmTicketTransaction = self::make($transactionAttributes);

        return $filmTicketTransaction;
    }

    public function appendCinemaDetails(): void
    {
        $cinemaFilm = CinemaFilm::with(["cinema", "film"])->find($this->cinema_film_id);
        $this->cinema_film = $cinemaFilm;
    }

    public function calculateTotal($voucherId)
    {
        // calculate the final percentage of price to be paid
        $voucher = Voucher::find($voucherId);
        $discount = 1;
        if ($voucher) {
            $discount = (100 - $voucher->off_percentage) / 100;
            $voucher->delete();
        }

        $this->total = $this->total * $discount;

        return $voucher;
    }

    public function processPayment(array $validated)
    {
        $voucher = $this->calculateTotal($validated["voucher"]);

        $this->status = "PENDING";
        $flipResponse = null;
        if ($validated["payment_method"] == "cash") {
            $this->method = "cash";
            $this->status = "SUCCESSFUL";
        } else if ($validated["payment_method"] == "flip") {
            $this->method = "flip";
            $filmName = $this->cinemaFilm->film->title;
            $cinemaName = $this->cinemaFilm->cinema->name;

            $response = FlipTransaction::createFlipBill(
                "Film Ticket - {$filmName} - {$cinemaName}",
                FlipBillType::SINGLE,
                $this->total,
                FlipStep::INPUT_DATA,
                "/film"
            );

            $flipResponse = $response;
        }

        $this->saveOrder($flipResponse);

        // appending extra data for receipt
        if ($voucher) {
            $this->voucher = $voucher->off_percentage . "%";
        }
        $this->cinema_film = $this->cinemaFilm;
        $this->payment_method = $this->method;
        $this->seats_coordinates_array = json_decode($this->seats_coordinates);    

        return $flipResponse;
    }

    public function saveOrder($flipResponse)
    {
        // unsetting cinema_film because it's no longer needed
        unset($this->cinema_film);

        $this->user_id = Auth::id();
        $this->flip_link_id = $flipResponse ? $flipResponse["link_id"] : null;
        $this->save();
    }
}
