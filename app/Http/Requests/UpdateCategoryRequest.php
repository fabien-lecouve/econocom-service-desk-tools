<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
            'project_id' => [
                'required',
                'integer',
                'exists:projects,id',
            ],

            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id')
                    ->where('project_id', $this->input('project_id')),
                Rule::notIn([$this->route('category')->id]),
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

            'position' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ];
    }
}
