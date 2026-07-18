<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'label' => [
                'required',
                'string',
                'max:100'
            ],

            'internal_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'external_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'string'
            ],

            'languages' => ['required', 'array'],
            'languages.*' => ['exists:languages,id'],
        ];
    }
}
