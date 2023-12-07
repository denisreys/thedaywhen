<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|min:3|max:30|regex:/^[a-zA-Z0-9_]+$/u',
            'password' => 'min:4|max:100',
        ];
    }
    public function messages(): array
    {
        return [
            'username.regex' => 'only Latin characters, numbers and underscore'
        ];
    }
}
