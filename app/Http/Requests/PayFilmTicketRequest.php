<?php

namespace App\Http\Requests;

use Closure;
use App\Models\Voucher;
use App\Enums\PaymentMethod;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PayFilmTicketRequest extends FormRequest
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
            "payment_method" => [
                "required",
                Rule::enum(PaymentMethod::class)
            ],
           "voucher" => [
                "required",
                function (string $attribute, mixed $value, Closure $fail) {
                    $voucher = Voucher::find($value);
                    // the voucher need not be found in vouchers table
                    // because if the user does not use any voucher,
                    // the $value will be -1
                    // in which case, the voucher do not need
                    // to be validated
                    $isVoucherValid = false;
                    if ($voucher) {
                        foreach (json_decode($voucher->valid_for) as $service) {
                            if ($service == "film_ticket") {
                                $isVoucherValid = true;
                            }
                        }
                        if (!$isVoucherValid) {
                            $fail("The {$attribute} is not valid for this service");
                        }
                    }
                }
            ]
        ];
    }
}
