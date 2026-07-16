<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => [
                'required',
                'integer',
                'exists:projects,id',
            ],

            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
                    ->where('project_id', $this->input('project_id')),
            ],

            'message_type_id' => [
                'required',
                'integer',
                'exists:message_types,id',
            ],

            'font_color_id' => [
                'nullable',
                'integer',
                'exists:colors,id',
            ],

            'background_color_id' => [
                'nullable',
                'integer',
                'exists:colors,id',
            ],

            'border_top_color_id' => [
                'nullable',
                'integer',
                'exists:colors,id',
            ],

            'label' => [
                'required',
                'string',
                'max:100',
            ],

            'shortcut' => [
                'nullable',
                'string',
                'size:1',
                Rule::unique('messages', 'shortcut')
                    ->where('project_id', $this->input('project_id')),
            ],

            'position' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'translations' => [
                'required',
                'array',
                'min:1',
            ],

            'translations.*.language_id' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('project_language_settings', 'language_id')
                    ->where('project_id', $this->input('project_id')),
            ],

            'translations.*.content' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $translations = collect($this->input('translations', []));

                $hasContent = $translations->contains(
                    fn (array $translation) =>
                        filled($translation['content'] ?? null)
                );

                if (! $hasContent) {
                    $validator->errors()->add(
                        'translations',
                        'Au moins une traduction doit être renseignée.'
                    );
                }
            },
        ];
    }
}
