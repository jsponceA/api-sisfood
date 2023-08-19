<?php

namespace App\Http\Controllers;

use App\Exports\ConsumptionExport;
use App\Exports\SubvencionExport;
use App\Http\Traits\ConsumptionTrait;
use App\Models\Area;
use App\Models\TypeForm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class ConsumptionController extends Controller
{
    use ConsumptionTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $page = $request->input("page");
        $perPage = $request->input("perPage");

        $comsumptions = $this->queryList($request)
            ->paginate($perPage, ["*"], "page", $page);

        return response()->json([
            "consumptions" => $comsumptions
        ], Response::HTTP_OK);
    }


    public function generateExcelConsumption(Request $request)
    {
        return Excel::download(new ConsumptionExport($request), 'reporte_consumos.xlsx');
    }

    public function generateExcelSubvencion(Request $request)
    {
        return Excel::download(new SubvencionExport($request), 'reporte_consumos.xlsx');
    }


    public function getAllResources(Request $request): JsonResponse
    {
        //example resourceTypes => "table1,table2,table,etc..."
        $resourceTypes = explode(",", $request->input("resourceTypes"));

        $response = [];
        if (in_array("categories", $resourceTypes)) {
            $response["categories"] = ["BEBIDAS","COMIDAS","SNACK","EXTRAS"];
        }
        if (in_array("typeForms", $resourceTypes)) {
            $response["typeForms"] = TypeForm::query()->orderByDesc("id")->get();
        }
        if (in_array("areas", $resourceTypes)) {
            $response["areas"] = Area::query()->orderByDesc("id")->get();
        }
        if (in_array("typeDiscounts", $resourceTypes)) {
            $response["typeDiscounts"] = ["SUBVENCION","DESCUENTO_PLANILLA","NO_DESCONTAR"];
        }


        return response()->json($response, Response::HTTP_OK);
    }
}
