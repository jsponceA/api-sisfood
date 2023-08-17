<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', "max:50",Rule::unique("users","username")->ignore(auth()->user()->id)->whereNull("deleted_at")],
            'password' => ['nullable', "max:255"],
            'email' => ['required','email', "max:100"],
            'photo' => ['nullable', "image", "max:5120"],
        ];
    }
}
