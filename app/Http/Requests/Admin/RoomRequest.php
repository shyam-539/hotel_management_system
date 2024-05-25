<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
            'lookuproom_id' => ['required'],
            'room_count' => ['required','numeric'],
            'bed_id.*' => ['required','exists:beds,id'],
            'room_size' => ['required','string'],
            'facility_ids' => ['required','array'],
            'facility_ids.*' => ['exists:lookup_facilities,id'],
            'description' => ['required','string'],
            'price' => ['required','numeric','min:3'],
            'images' => ['required','array'],
            'images.*' => ['image','mimes:jpeg,png,jpg,gif','max:2048'],
        ];
    }
}
