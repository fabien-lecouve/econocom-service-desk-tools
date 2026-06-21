<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMessageTranslationRequest extends FormRequest
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
            'message_id' => [
                'required',
                'integer',
                'exists:messages,id',
            ],

            'language_id' => [
                'required',
                'integer',
                'exists:languages,id',
                Rule::unique('message_translations', 'language_id')
                    ->where('message_id', $this->input('message_id'))
                    ->ignore($this->messageTranslation?->id),
            ],

            'content' => [
                'required',
                'string',
            ],
        ];
    }
}
