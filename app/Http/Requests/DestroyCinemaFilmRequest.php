<?php

namespace App\Http\Requests;

use Closure;
use App\Models\CinemaFilm;
use Illuminate\Foundation\Http\FormRequest;

class DestroyCinemaFilmRequest extends FormRequest
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
            "schedule_id" => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!$value) {
                        $fail("The given {$attribute} is invalid");
                    }

                    if (CinemaFilm::has("filmTicketTransaction")->find($value)) {
                        $fail("The given {$attribute} is being referenced by a film ticket transaction");
                    }
                }
            ]
        ];
    }
}
