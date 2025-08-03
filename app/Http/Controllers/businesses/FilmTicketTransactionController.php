<?php

namespace App\Http\Controllers\businesses;

use App\Enums\FlipBillType;
use App\Enums\FlipStep;
use App\Http\Requests\GetAiringCinemaRequest;
use App\Http\Requests\OrderFilmTicketRequest;
use App\Http\Requests\PayFilmTicketRequest;
use App\Services\FlipTransaction;
use Carbon\Carbon;
use App\Models\Film;
use App\Models\Cinema;
use App\Models\Voucher;
use App\Models\CinemaFilm;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\FilmTicketTransaction;

class FilmTicketTransactionController extends Controller
{
    public static function realSearchCinema($film_id)
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

    public function searchCinema(GetAiringCinemaRequest $getAiringCinemaRequest)
    {
        // $matchingCinemas = Cinema::join("cinema_film", "cinemas.id", "=", "cinema_film.cinema_id")->where("cinema_film.film_id", "=", $validated["film_id"])->get();
        $validated = $getAiringCinemaRequest->validated();

        $matching_cinemas = self::realSearchCinema($validated["film_id"]);

        return redirect("/film/cinema")->with("cinemas", $matching_cinemas);
    }

    public function order(OrderFilmTicketRequest $orderFilmTicketRequest)
    {
        $validated = $orderFilmTicketRequest->validated();

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

    public function makeTransaction(PayFilmTicketRequest $payFilmTicketRequest, FlipTransaction $flipTransaction)
    {
        $validated = $payFilmTicketRequest->validated();

        $voucher = Voucher::find($validated["voucher"]);

        $discount = 1;
        if ($voucher) {
            $discount = (100 - $voucher->off_percentage) / 100;
            $voucher->delete();
        }

        $transaction = session("film_ticket_transaction");
        $transaction->total = $transaction->total * $discount;
        $transaction->status = "PENDING";

        $cinema_film = CinemaFilm::find($transaction->cinema_film->id);
        $newSeats = json_decode($cinema_film->seats_status);

        foreach (session("seat_coordinates") as $seat_coord) {
            $col = explode(",", $seat_coord)[0];
            $row = explode(",", $seat_coord)[1];

            $newSeats[$row][$col] = 1;
        }

        $cinema_film->seats_status = json_encode($newSeats);
        $cinema_film->save();

        $flipResponse = null;
        if ($validated["payment_method"] == "cash") {
            $transaction->method = "cash";
            $transaction->status = "SUCCESSFUL";
        } else if ($validated["payment_method"] == "flip") {
            $transaction->method = "flip";
            $response = $flipTransaction->createFlipBill(
                "Film Ticket - {$cinema_film->film->name} - {$cinema_film->cinema->name}",
                FlipBillType::SINGLE,
                $transaction->total,
                FlipStep::INPUT_DATA,
                "/film/cinema"
            );

            $flipResponse = $response;
        }

        unset($transaction->cinema_film);

        $transaction->user_id = Auth::id();
        $transaction->flip_link_id = $flipResponse ? $flipResponse["link_id"] : null;
        $transaction->save();

        $transaction->cinema_film = $cinema_film;
        $transaction->payment_method = $validated["payment_method"];
        if ($voucher) {
            $transaction->voucher = $voucher->off_percentage . "%";
        }
        $transaction->seats_coordinates_array = session("seat_coordinates");

        return redirect("/film/cinema/seats/transaction/success")
            ->with("transaction", $transaction)
            ->with("flip_response", $flipResponse);
    }
}
