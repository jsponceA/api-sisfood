<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Branch;
use App\Models\Business;
use App\Models\Campus;
use App\Models\Category;
use App\Models\Charge;
use App\Models\Composition;
use App\Models\CostCenter;
use App\Models\Gender;
use App\Models\Managent;
use App\Models\OrganizationalUnit;
use App\Models\PayrollArea;
use App\Models\Role;
use App\Models\StaffDivision;
use App\Models\Superior;
use App\Models\TypeDocument;
use App\Models\TypeForm;
use App\Models\WorkerType;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['ADMIN', 'RRHH', 'VENTAS'] as $role) {
            Role::query()->firstOrCreate(['name' => $role]);
        }

        foreach (['SEDE PRINCIPAL', 'HUACHIPA', 'COMEDOR CENTRAL'] as $branch) {
            Branch::query()->firstOrCreate(['name' => $branch]);
        }

        foreach (['ALMACEN', 'PRODUCCION', 'LIMPIEZA', 'ACABADOS', 'ADMINISTRACION', 'VENTAS'] as $area) {
            Area::query()->firstOrCreate(['name' => $area]);
        }

        foreach (
            [
                ['name' => 'DESAYUNO', 'color' => '#3498db', 'code' => 'DES'],
                ['name' => 'ALMUERZO', 'color' => '#2ecc71', 'code' => 'ALM'],
                ['name' => 'CENA', 'color' => '#e74c3c', 'code' => 'CEN'],
                ['name' => 'EXTRAS', 'color' => '#f1c40f', 'code' => 'EXT'],
                ['name' => 'SNACKS', 'color' => '#9b59b6', 'code' => 'SNK'],
                ['name' => 'BEBIDAS', 'color' => '#e67e22', 'code' => 'BEB'],
                ['name' => 'GASEOSAS', 'color' => '#1abc9c', 'code' => 'GAS'],
                ['name' => 'TORTAS', 'color' => '#34495e', 'code' => 'TOR'],
            ] as $category
        ) {
            Category::query()->updateOrCreate(['name' => $category['name']], $category);
        }

        foreach (['DNI', 'CARNET DE EXTRANJERIA', 'PASAPORTE', 'RUC'] as $document) {
            TypeDocument::query()->firstOrCreate(['name' => $document]);
        }

        foreach (['PLANILLA', 'VISITA', 'PRACTICANTE', 'TERCERO'] as $typeForm) {
            TypeForm::query()->firstOrCreate(['name' => $typeForm]);
        }

        foreach (['HUACHIPA', 'SAN RAMON', 'SEDE LIMA'] as $campus) {
            Campus::query()->firstOrCreate(['name' => $campus]);
        }

        foreach (
            [
                ['code' => 'CC-001', 'name' => 'COMEDOR PRINCIPAL'],
                ['code' => 'CC-002', 'name' => 'OPERACIONES'],
                ['code' => 'CC-003', 'name' => 'ADMINISTRACION'],
            ] as $costCenter
        ) {
            CostCenter::query()->firstOrCreate($costCenter);
        }

        foreach (['PLANILLA EMPLEADOS', 'PLANILLA OBREROS', 'PRACTICANTES'] as $payrollArea) {
            PayrollArea::query()->firstOrCreate(['name' => $payrollArea]);
        }

        foreach (['OPERACIONES', 'ADMINISTRACION', 'GESTION HUMANA', 'VENTAS'] as $staffDivision) {
            StaffDivision::query()->firstOrCreate(['name' => $staffDivision]);
        }

        foreach (['UNIDAD OPERATIVA', 'UNIDAD ADMINISTRATIVA', 'UNIDAD LOGISTICA'] as $unit) {
            OrganizationalUnit::query()->firstOrCreate(['name' => $unit]);
        }

        foreach (['JORGE RUIZ', 'ANA FLORES', 'MARIO PEREZ', 'CLAUDIA VASQUEZ'] as $superior) {
            Superior::query()->firstOrCreate(['names' => $superior]);
        }

        foreach (['LUCEMIR', 'LUCEMIR HUACHIPA', 'SERVICIOS GENERALES'] as $business) {
            Business::query()->firstOrCreate(['name' => $business]);
        }

        foreach (['OPERARIO', 'SUPERVISOR', 'ASISTENTE', 'COCINERO', 'CAJERO'] as $charge) {
            Charge::query()->firstOrCreate(['name' => $charge]);
        }

        foreach (['FIJO', 'TEMPORAL', 'MIXTO'] as $composition) {
            Composition::query()->firstOrCreate(['name' => $composition]);
        }

        foreach (['MASCULINO', 'FEMENINO', 'NO ESPECIFICA'] as $gender) {
            Gender::query()->firstOrCreate(['name' => $gender]);
        }

        foreach (['EMPLEADO', 'OBRERO SEMANAL', 'PRACTICANTE'] as $workerType) {
            WorkerType::query()->firstOrCreate(['name' => $workerType]);
        }

        foreach (['GERENCIA GENERAL', 'GERENCIA DE OPERACIONES', 'GERENCIA DE VENTAS'] as $managent) {
            Managent::query()->firstOrCreate(['name' => $managent]);
        }
    }
}
