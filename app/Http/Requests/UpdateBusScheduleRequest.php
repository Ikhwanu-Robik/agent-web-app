<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBusScheduleRequest extends FormRequest
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
            "bus_id" => "required|exists:buses,id",
            "origin_station_id" => "required|exists:bus_stations,id",
            "destination_station_id" => "required|exists:bus_stations,id|different:origin_station_id",
            "departure_date" => "required|date",
            "departure_time" => "required", // I should add further validation, but I can only think of using Regex
            "seats" => "required|numeric",
            "ticket_price" => "required|numeric"
        ];
        // I need to validate that all record is unique
        // Two records may have the same departure_date and/or departure_time IF
        // Their bus is different
    }
}
