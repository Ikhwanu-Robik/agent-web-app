<?php

namespace App\Http\Requests;

use App\Http\Controllers\businesses\FilmTicketTransactionController;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class GetAiringCinemaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "film_id" => [
                "required",
                "numeric",
                "exists:films,id",
                function (string $attribute, mixed $value, Closure $fail) {
                    $matching_cinemas = FilmTicketTransactionController::realSearchCinema($value);

                    if (count($matching_cinemas) == 0) {
                        $fail("The film is not being aired in any cinema");
                    }
                }
            ],
        ];
    }
}
