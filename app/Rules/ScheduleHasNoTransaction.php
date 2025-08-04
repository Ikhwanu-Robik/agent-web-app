<?php

namespace App\Rules;

use Closure;
use App\Models\CinemaFilm;
use Illuminate\Contracts\Validation\ValidationRule;

class ScheduleHasNoTransaction implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (CinemaFilm::has("filmTicketTransaction")->find($value)) {
            $fail("The given {$attribute} is being referenced by a film ticket transaction");
        }
    }
}
