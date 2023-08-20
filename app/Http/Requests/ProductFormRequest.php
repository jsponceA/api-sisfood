<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductFormRequest extends FormRequest
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
                    //'name' => ['required', "max:255",Rule::unique("products","name")->whereNull("deleted_at")],
                    'name' => ['required','max:255'],
                    'category' => ['required'],
                    'barcode' => ['nullable', "max:100"],
                ];
            case "PUT":
                return [
                    //'name' => ['required', "max:255",Rule::unique("products","name")->ignore($this->route("product"))->whereNull("deleted_at")],
                    'name' => ['required','max:255'],
                    'category' => ['required'],
                    'barcode' => ['nullable', "max:100"],
                ];
            default:
                return [];
        }

    }

    public function attributes(): array
    {
        return [
            'name' => "nombre",
            'category' => "categoria",
            'barcode' => "codigo barras",
        ];
    }
}
