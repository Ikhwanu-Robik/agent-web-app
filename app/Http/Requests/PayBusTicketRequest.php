<?php

namespace App\Http\Requests;

use App\Enums\PaymentMethod;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PayBusTicketRequest extends FormRequest
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
            "bus_schedule_id" => "required|exists:bus_schedules,id",
            "ticket_amount" => "required|numeric",
            "payment_method" => ["required", Rule::enum(PaymentMethod::class)],
            "voucher" => "required"
        ];
    }
}
