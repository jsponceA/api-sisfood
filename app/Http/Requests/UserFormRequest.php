<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFormRequest extends FormRequest
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
         switch ($this->getMethod()){
            case "POST":
                return [
                    'rol_id' => ['required', Rule::exists("roles", "id")],
                    'branch_id' => ['required', Rule::exists("branches", "id")],
                    'username' => ['required', "max:50",Rule::unique("users","username")->whereNull("deleted_at")],
                    'password' => ['required', "max:255"],
                    'email' => ['required','email', "max:100"],
                    'photo' => ['nullable', "image", "max:5120"],
                ];
             case "PUT":
                 return [
                     'rol_id' => ['required', Rule::exists("roles", "id")],
                     'branch_id' => ['required', Rule::exists("branches", "id")],
                     'username' => ['required', "max:50",Rule::unique("users","username")->ignore($this->route("user"))->whereNull("deleted_at")],
                     'password' => ['nullable', "max:255"],
                     'email' => ['required','email', "max:100"],
                     'photo' => ['nullable', "image", "max:5120"],
                 ];
             default:
                 return [];
        }

    }

    public function attributes(): array
    {
        return [
            'rol_id' => "rol",
            'branch_id' => "sucursal",
            'username' => "usuario",
            'password' => "contraseña",
            'email' => "correo",
            'photo' => "fotografia",
        ];
    }
}
