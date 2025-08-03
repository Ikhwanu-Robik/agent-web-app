<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\PaymentMethod;

class PayBpjsTransactionRequest extends FormRequest
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
            "civil_id" => "required|exists:civil_informations,NIK",
            "month" => "required|numeric|min:1",
            "payment_method" => [
                "required",
                Rule::enum(PaymentMethod::class)
            ]
        ];
    }
}
