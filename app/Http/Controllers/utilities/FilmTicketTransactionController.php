<?php

namespace App\Http\Controllers\utilities;

use Closure;
use Carbon\Carbon;
use App\Models\Film;
use App\Models\Cinema;
use App\Models\Voucher;
use App\Models\CinemaFilm;
use App\Enums\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\FilmTicketTransaction;
use Illuminate\Support\Facades\Validator;

class FilmTicketTransactionController extends Controller
{
    private function realSearchCinema($film_id)
    {
        $cinemas = Cinema::with("films")->get();
        $searched_film = Film::find($film_id);

        $matching_cinemas = [];

        // foreach each cinema
        // and foreach the film they scheduled
        // if the film is the film we are looking for
        // mark the cinema as 'matching'
        foreach ($cinemas as $cinema) {
            foreach ($cinema->films as $film) {
                $isIdEqual = $film->film_schedule->film_id == $film_id;
                $isDateTodayOrTomorrow = Carbon::parse($film->film_schedule->airing_datetime)->gt(Carbon::now());

                $seats_status_array = json_decode($film->film_schedule->seats_status);
                $totalSeats = count($seats_status_array) * count($seats_status_array[0]);
                $filledSeats = 0;
                foreach ($seats_status_array as $row) {
                    foreach ($row as $col) {
                        if ($col == 1) {
                            $filledSeats++;
                        }
                    }
                }

                $isSeatsStillAvailable = $totalSeats != $filledSeats;

                if ($isIdEqual && $isDateTodayOrTomorrow && $isSeatsStillAvailable) {
                    array_push($matching_cinemas, $cinema);
                }
            }
        }

        // foreach each cinema
        // and foreach film they scheduled
        // if the film is the film we are looking for
        // put it in temporary array, $matchingFilms
        // then replace the cinema's films with the
        // temporary array
        // this is to ensure the matching_cinemas being
        // returned only with the requested film
        foreach ($matching_cinemas as $cinema) {
            $matchingFilms = [];

            foreach ($cinema->films as $film) {
                if ($film->title == $searched_film->title) {
                    array_push($matchingFilms, $film);
                }
            }

            $cinema->films = $matchingFilms;
        }

        return $matching_cinemas;
    }

    public function searchCinema(Request $request)
    {
        // $matchingCinemas = Cinema::join("cinema_film", "cinemas.id", "=", "cinema_film.cinema_id")->where("cinema_film.film_id", "=", $validated["film_id"])->get();
        $validated = $request->validate([
            "film_id" => "required|numeric|exists:films,id"
        ]);

        $matching_cinemas = self::realSearchCinema($validated["film_id"]);

        $validator = Validator::make($request->all(), [
            "film_id" => [
                function (string $attribute, mixed $value, Closure $fail) {
                    $matching_cinemas = self::realSearchCinema($value);

                    if (count($matching_cinemas) == 0) {
                        $fail("The film is not being aired in any cinema");
                    }
                }
            ]
        ]);

        $validator->validate();

        return redirect("/film/cinema")->with("cinemas", $matching_cinemas);
    }

    public function order(Request $request)
    {
        $validated = $request->validate([
            "cinema_film_id" => "required|exists:cinema_film,id",
            "seat_coordinates" => "required|array"
        ]);

        $cinemaFilm = CinemaFilm::with("cinema", "film")->find($validated["cinema_film_id"]);

        $transactionAttributes = [
            "cinema_film_id" => $cinemaFilm->id,
            "seats_coordinates" => json_encode($validated["seat_coordinates"]),
            "total" => $cinemaFilm->ticket_price * count($validated["seat_coordinates"]),
        ];
        $filmTicketTransaction = FilmTicketTransaction::make($transactionAttributes);

        return redirect("/film/cinema/payment")
            ->with("film_ticket_transaction", $filmTicketTransaction)
            ->with("seat_coordinates", $validated["seat_coordinates"]);
    }

    public function makeTransaction(Request $request)
    {
        $validated = $request->validate([
            "payment_method" => [
                "required",
                Rule::enum(PaymentMethod::class)
            ],
            "voucher" => "required"
        ]);

        $voucher = Voucher::find($validated["voucher"]);
        $isVoucherValid = false;
        if ($voucher) {
            foreach (json_decode($voucher->valid_for) as $service) {
                if ($service == "film_ticket") {
                    $isVoucherValid = true;
                }
            }
        }

        $discount = 1;
        if ($validated["voucher"] != -1 && $isVoucherValid) {
            $discount = (100 - $voucher->off_percentage) / 100;

            $voucher->delete();
        }

        $transaction = session("film_ticket_transaction");
        $transaction->total = $transaction->total * $discount;

        $cinema_film = CinemaFilm::find($transaction->cinema_film->id);
        $newSeats = json_decode($cinema_film->seats_status);
        foreach (session("seat_coordinates") as $seat_coord) {
            $col = explode(",", $seat_coord)[0];
            $row = explode(",", $seat_coord)[1];

            $newSeats[$row][$col] = 1;
        }
        $cinema_film->seats_status = json_encode($newSeats);
        $cinema_film->save();

        if ($validated["payment_method"] == "cash") {
            $transaction->method = "cash";
            $transaction->status = "finish";
        } else if ($validated["payment_method"] == "flip") {
            // call Flip's API
        }

        unset($transaction->cinema_film);
        $transaction->user_id = Auth::id();
        $transaction->save();

        $transaction->cinema_film = $cinema_film;
        $transaction->payment_method = $validated["payment_method"];
        if ($validated["voucher"] != -1 && $isVoucherValid) {
            $transaction->voucher = $voucher->off_percentage . "%";
        }
        $transaction->seats_coordinates_array = session("seat_coordinates");

        return redirect("/film/cinema/seats/transaction/success")->with("transaction", $transaction);
    }
}
