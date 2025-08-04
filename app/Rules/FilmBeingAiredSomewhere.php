<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Controllers\businesses\FilmTicketTransactionController;

class FilmBeingAiredSomewhere implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $matching_cinemas = FilmTicketTransactionController::realSearchCinema($value);

        if (count($matching_cinemas) == 0) {
            $fail("The film is not being aired in any cinema");
        }
    }
}
