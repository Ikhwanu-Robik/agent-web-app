<?php

namespace App\Rules;

use Closure;
use App\Models\Voucher;
use Illuminate\Contracts\Validation\ValidationRule;

class VoucherValid implements ValidationRule
{
    private $originService;

    public function __construct(string $originService)
    {
        $this->originService = $originService;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $voucher = Voucher::find($value);
        // the voucher need not be found in vouchers table
        // because if the user does not use any voucher,
        // the $value will be -1
        // in which case, the voucher do not need
        // to be validated
        $isVoucherValid = false;
        if ($voucher) {
            foreach (json_decode($voucher->valid_for) as $service) {
                if ($service == $this->originService) {
                    $isVoucherValid = true;
                }
            }
            if (!$isVoucherValid) {
                $fail("The {$attribute} is not valid for this service");
            }
        }
    }
}
