<?php

namespace App\Rules;

use App\Models\Cinema;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FilmBeingAiredSomewhere implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $matching_cinemas = Cinema::findAiring($value);

        if (count($matching_cinemas) == 0) {
            $fail("The film is not being aired in any cinema");
        }
    }
}
