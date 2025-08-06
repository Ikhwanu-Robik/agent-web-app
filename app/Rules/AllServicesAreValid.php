<?php

namespace App\Rules;

use App\Enums\ValidServices;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Controllers\resources\VoucherController;

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
            foreach (array_column(ValidServices::cases(), "value") as $valid) {
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
