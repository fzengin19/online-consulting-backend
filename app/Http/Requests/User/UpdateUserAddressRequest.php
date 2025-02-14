<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserAddressRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'latitude' => [
                'required',
                'numeric',
                'regex:/^-?\d{1,2}\.\d{1,8}$/',
            ],
            'longitude' => [
                'required',
                'numeric',
                'regex:/^-?\d{1,3}\.\d{1,8}$/',
            ],
            'place_id' => 'required|string',
        ];
    }
}
