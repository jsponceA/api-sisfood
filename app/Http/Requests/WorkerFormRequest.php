<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkerFormRequest extends FormRequest
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
                    'type_form_id' => ['required'],
                    'area_id' => ['required'],
                    'cost_center_id' => ['required'],
                    'campus_id' => ['required'],
                    'type_document_id' => ['required'],
                    'gender_id' => ['nullable'],
                    'names' => ['required', "max:100"],
                    'surnames' => ['required', "max:100"],
                    'numdoc' => ['required', "max:20"],
                    'phone' => ['nullable',"max:20"],
                    'address' => ['nullable',"max:250"],
                    'birth_date' => ['nullable',"date"],
                    'admission_date' => ['required',"date"],
                    'suspension_date' => ['nullable',"date"],
                    'terminated_worker' => ['nullable',"boolean"],
                ];
            case "PUT":
                return [
                    'type_form_id' => ['required'],
                    'area_id' => ['required'],
                    'cost_center_id' => ['required'],
                    'campus_id' => ['required'],
                    'type_document_id' => ['required'],
                    'gender_id' => ['nullable'],
                    'names' => ['required', "max:100"],
                    'surnames' => ['required', "max:100"],
                    'numdoc' => ['required', "max:20"],
                    'phone' => ['nullable',"max:20"],
                    'address' => ['nullable',"max:250"],
                    'birth_date' => ['nullable',"date"],
                    'admission_date' => ['required',"date"],
                    'suspension_date' => ['nullable',"date"],
                    'terminated_worker' => ['nullable',"boolean"],
                ];
            default:
                return [];
        }

    }

    public function attributes(): array
    {
        return [
            'type_form_id' => "Planilla",
            'area_id' => "Area",
            'cost_center_id' => "Centro de costo",
            'campus_id' => "Sede",
            'type_document_id' => "tipo documento",
            'gender_id' => "genero",
            'names' => "Nombres",
            'surnames' => "Apellidos",
            'numdoc' => "Numero documento",
            'phone' => "celular",
            'address' => "Dirección",
            'birth_date' => "Fecha nacimiento",
            'admission_date' => "Fecha ingreso",
            'suspension_date' => "Fecha suspensión",
            'terminated_worker' => "Cesado",
        ];
    }
}
