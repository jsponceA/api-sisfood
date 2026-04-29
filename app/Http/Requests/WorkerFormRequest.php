<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WorkerFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('fingerprints') && is_string($this->input('fingerprints'))) {
            $fingerprints = json_decode($this->input('fingerprints'), true);

            $this->merge([
                'fingerprints' => is_array($fingerprints) ? $fingerprints : [],
            ]);
        }
    }

    public function rules(): array
    {
        $workerRules = [
            'type_form_id' => ['nullable'],
            'area_id' => ['nullable'],
            'cost_center_id' => ['nullable'],
            'campus_id' => ['nullable'],
            'payroll_area_id' => ['nullable'],
            'staff_division_id' => ['nullable'],
            'organizational_unit_id' => ['nullable'],
            'superior_id' => ['nullable'],
            'business_id' => ['nullable'],
            'charge_id' => ['nullable'],
            'composition_id' => ['nullable'],
            'gender_id' => ['nullable'],
            'type_document_id' => ['required'],
            'worker_type_id' => ['nullable'],
            'managent_id' => ['nullable'],
            'personal_code' => ['nullable', 'max:100'],
            'names' => ['required', 'max:100'],
            'surnames' => ['nullable', 'max:100'],
            'phone' => ['nullable', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'address' => ['nullable', 'max:250'],
            'birth_date' => ['nullable', 'date'],
            'admission_date' => ['required', 'date'],
            'suspension_date' => ['nullable', 'date'],
            'terminated_worker' => ['nullable', 'boolean'],
            'breakfast' => ['nullable', 'boolean'],
            'lunch' => ['nullable', 'boolean'],
            'dinner' => ['nullable', 'boolean'],
            'grant' => ['nullable', 'boolean'],
            'grant_complete' => ['nullable', 'boolean'],
            'allowed_meals' => ['nullable', 'array'],
            'allowed_meals.*' => ['nullable'],
            'condition' => ['nullable', 'max:100'],
            'cod_reg_lab' => ['nullable', 'max:100'],
            'photo' => ['nullable', 'image'],
        ];

        $fingerprintRules = [
            'fingerprints' => ['nullable', 'array', 'max:10'],
            'fingerprints.*.finger_label' => ['nullable', 'string', 'max:100'],
            'fingerprints.*.sample_format' => ['required_with:fingerprints', 'integer', Rule::in([1, 2, 3, 5])],
            'fingerprints.*.sample_data' => ['required_with:fingerprints', 'string'],
            'fingerprints.*.image_data' => ['nullable', 'string'],
            'fingerprints.*.device_uid' => ['nullable', 'string', 'max:191'],
            'fingerprints.*.quality' => ['nullable', 'integer', 'between:0,255'],
            'fingerprints.*.capture_metadata' => ['nullable', 'array'],
        ];

        switch ($this->getMethod()) {
            case "POST":
                return array_merge($workerRules, [
                    'numdoc' => ['required', 'max:20', Rule::unique('workers', 'numdoc')->whereNull('deleted_at')],
                ], $fingerprintRules);
            case "PUT":
                return array_merge($workerRules, [
                    'numdoc' => ['required', 'max:20', Rule::unique('workers', 'numdoc')->ignore($this->route()->parameter('worker'))->whereNull('deleted_at')],
                ], $fingerprintRules);
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
            'payroll_area_id' => 'Área de nómina',
            'staff_division_id' => 'División de personal',
            'organizational_unit_id' => 'Unidad organizativa',
            'superior_id' => 'Superior',
            'business_id' => 'Negocio',
            'charge_id' => 'Cargo',
            'composition_id' => 'Composición',
            'type_document_id' => "tipo documento",
            'worker_type_id' => 'tipo de trabajador',
            'managent_id' => 'gerencia',
            'personal_code' => 'código personal',
            'gender_id' => "genero",
            'names' => "Nombres",
            'surnames' => "Apellidos",
            'numdoc' => "Numero documento",
            'phone' => "celular",
            'email' => 'correo',
            'address' => "Dirección",
            'birth_date' => "Fecha nacimiento",
            'admission_date' => "Fecha ingreso",
            'suspension_date' => "Fecha suspensión",
            'terminated_worker' => "Cesado",
            'breakfast' => 'desayuno',
            'lunch' => 'almuerzo',
            'dinner' => 'cena',
            'photo' => "foto",
            'grant' => 'subvención',
            'grant_complete' => 'subvención completa',
            'allowed_meals' => 'consumos permitidos',
            'allowed_meals.*' => 'consumo permitido',
            'condition' => 'condición',
            'cod_reg_lab' => 'código de registro laboral',
            'fingerprints' => 'huellas digitales',
            'fingerprints.*.finger_label' => 'etiqueta de huella',
            'fingerprints.*.sample_format' => 'formato de huella',
            'fingerprints.*.sample_data' => 'muestra de huella',
            'fingerprints.*.image_data' => 'imagen de huella',
            'fingerprints.*.device_uid' => 'lector de huella',
            'fingerprints.*.quality' => 'calidad de huella',
        ];
    }
}
