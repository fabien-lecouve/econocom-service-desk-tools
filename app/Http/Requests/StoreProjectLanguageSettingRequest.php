<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectLanguageSettingRequest extends FormRequest
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
            'project_id' => ['required', 'exists:projects,id'],

            'languages' => ['required', 'array'],

            'languages.*.language_id' => [
                'required',
                'exists:languages,id',
            ],

            'languages.*.signature' => [
                'required',
                'string',
            ],

            'languages.*.internal_phone_override' => [
                'nullable',
                'string',
                'max:30',
            ],

            'languages.*.external_phone_override' => [
                'nullable',
                'string',
                'max:30',
            ],
        ];
    }
}
