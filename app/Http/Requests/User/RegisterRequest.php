<?php

namespace App\Http\Requests\User;

use Doctrine\Inflector\Rules\English\Rules;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'first_name' => ['required', 'string','min:3', 'max:255'],
            'last_name' => [ 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'digits:10', 'regex:/[6789][0-9]{9}/', 'unique:'.User::class], // Updated regex
            
            'city' => ['required', 'string','min:3', 'max:255'],
            'district' => ['required', 'string','min:3', 'max:255'],
            'state' => ['required', 'string','min:3', 'max:255'],
            'pin_code' => ['required', 'string','min:3', 'max:255'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ];
    }
}
