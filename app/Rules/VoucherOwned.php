<?php

namespace App\Rules;

use Closure;
use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\ValidationRule;

class VoucherOwned implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $voucher = Voucher::find($value);
        if ($voucher->user_id != Auth::id()) {
            $fail("The voucher must belong to you");
        }
    }
}
