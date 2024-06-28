<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApartmentRequest extends FormRequest
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
            'title' => 'required|string',
            'rooms' => 'required|numeric|min:1|max:100',
            'beds' => 'required|numeric|min:1|max:100',
            'bathrooms' => 'required|numeric|min:1|max:100|lte:rooms',
            'sqr_mt' => 'required|numeric|min:1',
            'address' => 'required|string',
            'visible' => 'boolean'
        ];
    }
}
