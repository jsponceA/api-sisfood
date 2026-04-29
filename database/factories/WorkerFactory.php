<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\Business;
use App\Models\Campus;
use App\Models\Charge;
use App\Models\Composition;
use App\Models\CostCenter;
use App\Models\Gender;
use App\Models\Managent;
use App\Models\OrganizationalUnit;
use App\Models\PayrollArea;
use App\Models\StaffDivision;
use App\Models\Superior;
use App\Models\TypeDocument;
use App\Models\TypeForm;
use App\Models\Worker;
use App\Models\WorkerType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Worker>
 */
class WorkerFactory extends Factory
{
    protected $model = Worker::class;

    public function definition(): array
    {
        $allowedMeals = fake()->randomElements(['1', '2', '3'], fake()->numberBetween(1, 3));
        sort($allowedMeals);

        $grantComplete = fake()->boolean(20);
        $grant = $grantComplete ? false : fake()->boolean(35);
        $birthDate = fake()->dateTimeBetween('-55 years', '-18 years');
        $admissionDate = fake()->dateTimeBetween('-10 years', 'now');
        $terminatedWorker = fake()->boolean(8);

        return [
            'type_form_id' => fn() => TypeForm::query()->inRandomOrder()->value('id')
                ?? TypeForm::query()->create(['name' => 'PLANILLA'])->id,
            'area_id' => fn() => Area::query()->inRandomOrder()->value('id')
                ?? Area::query()->create(['name' => 'PRODUCCION'])->id,
            'cost_center_id' => fn() => CostCenter::query()->inRandomOrder()->value('id')
                ?? CostCenter::query()->create(['code' => 'CC-001', 'name' => 'CENTRO PRINCIPAL'])->id,
            'campus_id' => fn() => Campus::query()->inRandomOrder()->value('id')
                ?? Campus::query()->create(['name' => 'HUACHIPA'])->id,
            'payroll_area_id' => fn() => PayrollArea::query()->inRandomOrder()->value('id')
                ?? PayrollArea::query()->create(['name' => 'PLANILLA EMPLEADOS'])->id,
            'staff_division_id' => fn() => StaffDivision::query()->inRandomOrder()->value('id')
                ?? StaffDivision::query()->create(['name' => 'OPERACIONES'])->id,
            'organizational_unit_id' => fn() => OrganizationalUnit::query()->inRandomOrder()->value('id')
                ?? OrganizationalUnit::query()->create(['name' => 'UNIDAD OPERATIVA'])->id,
            'superior_id' => fn() => Superior::query()->inRandomOrder()->value('id')
                ?? Superior::query()->create(['names' => fake()->name()])->id,
            'business_id' => fn() => Business::query()->inRandomOrder()->value('id')
                ?? Business::query()->create(['name' => 'LUCEMIR'])->id,
            'charge_id' => fn() => Charge::query()->inRandomOrder()->value('id')
                ?? Charge::query()->create(['name' => 'OPERARIO'])->id,
            'composition_id' => fn() => Composition::query()->inRandomOrder()->value('id')
                ?? Composition::query()->create(['name' => 'FIJO'])->id,
            'gender_id' => fn() => Gender::query()->inRandomOrder()->value('id')
                ?? Gender::query()->create(['name' => 'MASCULINO'])->id,
            'type_document_id' => fn() => TypeDocument::query()->inRandomOrder()->value('id')
                ?? TypeDocument::query()->create(['name' => 'DNI'])->id,
            'worker_type_id' => fn() => WorkerType::query()->inRandomOrder()->value('id')
                ?? WorkerType::query()->create(['name' => 'EMPLEADO'])->id,
            'managent_id' => fn() => Managent::query()->inRandomOrder()->value('id')
                ?? Managent::query()->create(['name' => 'GERENCIA GENERAL'])->id,
            'personal_code' => strtoupper(fake()->unique()->bothify('EMP-#####')),
            'names' => fake()->firstName() . ' ' . fake()->firstName(),
            'surnames' => fake()->lastName() . ' ' . fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'numdoc' => fake()->unique()->numerify('########'),
            'phone' => '9' . fake()->numerify('########'),
            'address' => fake()->address(),
            'birth_date' => $birthDate->format('Y-m-d'),
            'admission_date' => $admissionDate->format('Y-m-d'),
            'suspension_date' => $terminatedWorker
                ? fake()->dateTimeBetween($admissionDate, 'now')->format('Y-m-d')
                : null,
            'terminated_worker' => $terminatedWorker,
            'breakfast' => in_array('1', $allowedMeals, true),
            'lunch' => in_array('2', $allowedMeals, true),
            'dinner' => in_array('3', $allowedMeals, true),
            'grant' => $grant,
            'grant_complete' => $grantComplete,
            'allowed_meals' => $allowedMeals,
            'condition' => fake()->randomElement(['ACTIVO', 'VACACIONES', 'DESCANSO MEDICO', 'SUSPENDIDO']),
            'cod_reg_lab' => fake()->randomElement(['20', '21', '81']),
            'photo' => null,
        ];
    }
}
