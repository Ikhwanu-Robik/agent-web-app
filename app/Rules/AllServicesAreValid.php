<?php

namespace App\Rules;

use Closure;
use App\Enums\ValidService;
use Illuminate\Contracts\Validation\ValidationRule;

class AllServicesAreValid implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if all element of $input is also element of $valid_services
        $isAllInputValidServices = false;

        $validCount = 0;
        foreach ($value as $service) {
            foreach (array_column(ValidService::cases(), "value") as $valid) {
                if ($service == $valid) {
                    $validCount++;
                    break;
                }
            }
        }

        if (count($value) != $validCount) {
            $isAllInputValidServices = false;
        } else if (count($value) == $validCount) {
            $isAllInputValidServices = true;
        }

        if (!$isAllInputValidServices) {
            $fail("The " . $attribute . " contains invalid service");
        }
    }
}
