<?php

namespace App\Http\Requests;

use App\Http\Controllers\resources\VoucherController;
use Closure;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVoucherRequest extends FormRequest
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
            "off_percentage" => "required|numeric|max:100",
            "valid_for" => [
                "required",
                "array",
                function (string $attribute, mixed $value, Closure $fail) {
                    // Check if all element of $input is also element of $valid_services
                    $isAllInputValidServices = false;

                    $validCount = 0;
                    foreach ($value as $service) {
                        foreach (VoucherController::$valid_services as $valid) {
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
            ],
            "user_id" => "required|numeric"
        ];
    }
}
