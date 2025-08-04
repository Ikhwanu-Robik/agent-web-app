<?php

namespace App\Http\Requests;

use App\Rules\AllServicesAreValid;
use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherRequest extends FormRequest
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
            "off_percentage" => "required|numeric",
            "valid_for" => [
                "required",
                "array",
                new AllServicesAreValid
            ],
            "user_id" => "required|numeric|exists:users,id"
        ];
    }
}
