<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
            'firstname' => [
                'required',
                'string',
                'max:100',
            ],

            'lastname' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->user),
            ],

            'password' => [
                'nullable',
                'confirmed',
                Password::defaults(),
            ],

            'is_admin' => [
                'sometimes',
                'boolean',
            ],

            'is_knowledge_manager' => [
                'sometimes',
                'boolean',
            ],

            'memberships' => [
                'required',
                'array',
                'min:1',
            ],

            'memberships.*.project_id' => [
                'required',
                'integer',
                'exists:projects,id',
                'distinct',
            ],

            'memberships.*.role_id' => [
                'required',
                'integer',
                'exists:roles,id',
            ],
        ];
    }
}
