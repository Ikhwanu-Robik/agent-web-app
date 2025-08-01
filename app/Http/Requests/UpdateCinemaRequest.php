<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCinemaRequest extends FormRequest
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
        $cinema = $this->route("cinema");
        $seats_structure = json_decode($cinema->seats_structure);
        $oriRow = count($seats_structure);
        $oriCol = count($seats_structure[0]);

        return [
            "name" => "required|string",
            "seats_structure" => ["missing_unless:seats_structure_width,$oriCol", "missing_unless:seats_structure_height,$oriRow", "array"],
            "seats_structure_width" => ["exclude_with:seats_structure", "required_with:seats_structure_height", "numeric"],
            "seats_structure_height" => ["exclude_with:seats_structure", "required_with:seats_structure_width", "numeric"]
        ];
    }
}
