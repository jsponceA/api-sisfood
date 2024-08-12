<?php

namespace App\Imports;

use App\Models\Area;
use App\Models\Business;
use App\Models\Campus;
use App\Models\Charge;
use App\Models\Composition;
use App\Models\CostCenter;
use App\Models\Gender;
use App\Models\OrganizationalUnit;
use App\Models\StaffDivision;
use App\Models\Superior;
use App\Models\TypeForm;
use App\Models\Worker;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;

class WorkerImport implements ToCollection, WithStartRow, WithHeadingRow
{
    public function collection(Collection $collection)
    {
        $collection->each(function ( $row) {
            $item = json_decode(json_encode($row));

            /*$verificarAreaPersonal = Area::query()->where("name", $item->area_de_personal)->exists();
            if (!$verificarAreaPersonal) {
                Area::query()->create(["name" => $item->area_de_personal]);
            }

            $verficarCargo = Charge::query()->where("name", $item->cargo)->exists();
            if (!$verficarCargo) {
                Charge::query()->create(["name" => $item->cargo]);
            }

            $verficarCentroCosto = CostCenter::query()->where("name", $item->centro_de_coste)->exists();
            if (!$verficarCentroCosto) {
                CostCenter::query()->create(["name" => $item->centro_de_coste]);
            }

            $verficarUnidadOrganizativa = OrganizationalUnit::query()->where("name", $item->unidad_organizativa)->exists();
            if (!$verficarUnidadOrganizativa) {
                OrganizationalUnit::query()->create(["name" => $item->unidad_organizativa]);
            }*/

            /*if (!empty($item->nombre_del_superior_go)){
                $verficarSuperior = Superior::query()->where("names", $item->nombre_del_superior_go)->exists();
                if (!$verficarSuperior) {
                    Superior::query()->create(["names" => $item->nombre_del_superior_go]);
                }
            }*/

            /*$verficarNegocio = Business::query()->where("name", $item->negocio)->exists();
            if (!$verficarNegocio) {
                Business::query()->create(["name" => $item->negocio]);
            }*/

            /*$verficarComposicion = Composition::query()->where("name", $item->composicion)->exists();
            if (!$verficarComposicion) {
                Composition::query()->create(["name" => $item->composicion]);
            }*/

             Worker::query()->create([
                // "type_form_id" => TypeForm::query()->where("name",$item->relacion_laboral)->first()->id,
                 "area_id" => Area::query()->where("name",$item->area_de_personal)->first()->id,
                 "cost_center_id" => CostCenter::query()->where("name",$item->centro_de_coste)->first()->id,
                 "campus_id" => 1,
                 "payroll_area_id" => 1,
                 "staff_division_id" => 1,
                 "organizational_unit_id" => OrganizationalUnit::query()->where("name",$item->unidad_organizativa)->first()->id,
                // "superior_id" => Superior::query()->where("names",$item->nombre_del_superior_go)->first()?->id ?? null,
                // "business_id" => Business::query()->where("name",$item->negocio)->first()->id,
                 "charge_id" => Charge::query()->where("name",$item->cargo)->first()->id,
                 //"composition_id" => Composition::query()->where("name",$item->composicion)->first()->id,
                 //"gender_id" => Gender::query()->where("name",$item->clave_de_sexo)->first()->id,
                 "type_document_id" => 1,
                 //"personal_code" =>$item->no_pers,
                 "names" => $item->apellidos_nombres,
                 //"surnames" => $item->apellido." ".$item->apellido_materno,
                 "email" => null,
                 "numdoc" => $item->dni,
                 "phone" => null,
                 "address" => null,
                // "birth_date" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item->fecha_nac)->format('Y-m-d'),
                 //"admission_date" => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($item->desde)->format('Y-m-d'),
                 "suspension_date" => null,
                 "terminated_worker" => 0,
                // "breakfast" => 1,
                // "lunch" => 1,
                 //"dinner" => 1,
                 "grant" => 1,
                 "grant_complete" => 0,
                 "allowed_meals" => [1,2,3],
                 "condition" => $item->condicion
             ]);

        });
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function startRow(): int
    {
        return 2;
    }


}
