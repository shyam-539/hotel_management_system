<?php

namespace App\Http\Requests\User;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class BookingRequest extends FormRequest
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
   public function rules()
    {
        // $availableRoomCount = $this->input('availableRoomCount') ?? PHP_INT_MAX;

        return [
            'roomCount' => 'required|integer|min:1|max:' . $this->input('availableRoomCount'),
        'extraBedCount' => 'required|integer|min:0|max:3',
        'totalPrice' => 'required|numeric',
        'taxPercentage' => 'required|numeric',
        'taxAmount' => 'required|numeric',
        'netAmount' => 'required|numeric',
        'checkin' => [
            'required',
            'date',
            function ($attribute, $value, $fail) {
                $checkinDate = Carbon::parse($value);
                if ($checkinDate->isPast()) {
                    $fail('The check-in date must be today or a future date.');
                }
            },
        ],
        'checkout' => [
            'required',
            'date',
            function ($attribute, $value, $fail) {
                $checkoutDate = Carbon::parse($value);
                $checkinDate = Carbon::parse($this->input('checkin'));
                if ($checkoutDate->isPast()) {
                    $fail('The check-out date must be a future date.');
                }
                if ($checkoutDate->lte($checkinDate)) {
                    $fail('The check-out date must be after the check-in date.');
                }
            },
        ],
        'adultCount' => 'required|integer|min:1|max:5',
        'kidsCount'  => 'nullable|integer|max:4',
    ];

    }

    public function messages()
    {
        return [
            'roomCount.required' => 'Room count is required.',
            'roomCount.integer' => 'Room count must be an integer.',
            'roomCount.min' => 'Room count must be at least 1.',
            'roomCount.max' => 'Room count cannot exceed the available room count.',
            'extraBedCount.required' => 'Extra bed count is required.',
            'extraBedCount.integer' => 'Extra bed count must be an integer.',
            'extraBedCount.min' => 'Extra bed count cannot be less than 0.',
            'extraBedCount.max' => 'You can add a maximum of 3 extra beds.',
            // Add more messages for other inputs if necessary
        ];
    }
 
}
