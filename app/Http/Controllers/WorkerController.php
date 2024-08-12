<?php

namespace App\Http\Controllers;

use App\Exports\WorkerExport;
use App\Http\Requests\WorkerFormRequest;
use App\Http\Traits\WorkerTrait;
use App\Models\Area;
use App\Models\Business;
use App\Models\Campus;
use App\Models\Category;
use App\Models\Charge;
use App\Models\Composition;
use App\Models\CostCenter;
use App\Models\Gender;
use App\Models\OrganizationalUnit;
use App\Models\PayrollArea;
use App\Models\StaffDivision;
use App\Models\Superior;
use App\Models\TypeDocument;
use App\Models\TypeForm;
use App\Models\Worker;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class WorkerController extends Controller
{
    use WorkerTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $page = $request->input("page");
        $perPage = $request->input("perPage");

        $workers = $this->queryList($request)
            ->paginate($perPage, ["*"], "page", $page);

        return response()->json([
            "workers" => $workers
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorkerFormRequest $request): JsonResponse
    {
        $data = $request->all();

        $worker = Worker::query()->create($data);

        return response()->json([
            "message" => "Trabajador creado satisfactoriamente"
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $worker = Worker::query()->findOrFail($id);

        return response()->json([
            "worker" => $worker
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkerFormRequest $request, int $id): JsonResponse
    {

        $data = $request->all();

        $worker = Worker::query()->findOrFail($id);
        $worker->update($data);

        return response()->json([
            "message" => "Trabajador modificado satisfactoriamente"
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $worker = Worker::query()->findOrFail($id);
        $worker->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Get All resource for all actions
     */


    public function generatePdf(Request $request)
    {
        $workers = $this->queryList($request)->get();

        $pdf = Pdf::loadView('reports.worker.list_pdf', compact("workers"))
            ->setPaper("A4", "landscape");
        return $pdf->download('reporte_trabajadores.pdf');
    }

    public function generateExcel(Request $request)
    {
        return Excel::download(new WorkerExport($request), 'reporte_trabajadores.xlsx');
    }

    public function searchSensitive(Request $request)
    {
        $search = trim($request->input("search"));

        $workers = Worker::query()
            ->where("numdoc", $search)
            ->orWhere("names", $search)
            ->orWhere("surnames", $search)
            ->orderByDesc("id")
            ->take(10)
            ->get();

        return response()->json([
            "workers" => $workers
        ], Response::HTTP_OK);
    }

    public function getAllResources(Request $request): JsonResponse
    {
        //example resourceTypes => "table1,table2,table,etc..."
        $resourceTypes = explode(",", $request->input("resourceTypes"));

        $response = [];
        if (in_array("genders", $resourceTypes)) {
            $response["genders"] = Gender::query()->orderByDesc("id")->get();
        }
        if (in_array("typedocs", $resourceTypes)) {
            $response["typedocs"] = TypeDocument::query()->orderByDesc("id")->get();
        }
        if (in_array("campuses", $resourceTypes)) {
            $response["campuses"] = Campus::query()->orderByDesc("id")->get();
        }
        if (in_array("typeForms", $resourceTypes)) {
            $response["typeForms"] = TypeForm::query()->orderByDesc("id")->get();
        }
        if (in_array("areas", $resourceTypes)) {
            $response["areas"] = Area::query()->orderByDesc("id")->get();
        }
        if (in_array("costCenters", $resourceTypes)) {
            $response["costCenters"] = CostCenter::query()->orderByDesc("id")->get();
        }
        if (in_array("payrollAreas", $resourceTypes)) {
            $response["payrollAreas"] = PayrollArea::query()->orderByDesc("id")->get();
        }
        if (in_array("staffDivisions", $resourceTypes)) {
            $response["staffDivisions"] = StaffDivision::query()->orderByDesc("id")->get();
        }
        if (in_array("organizationalUnits", $resourceTypes)) {
            $response["organizationalUnits"] = OrganizationalUnit::query()->orderByDesc("id")->get();
        }
        if (in_array("superiors", $resourceTypes)) {
            $response["superiors"] = Superior::query()->orderByDesc("id")->get();
        }
        if (in_array("businesses", $resourceTypes)) {
            $response["businesses"] = Business::query()->orderByDesc("id")->get();
        }
        if (in_array("charges", $resourceTypes)) {
            $response["charges"] = Charge::query()->orderByDesc("id")->get();
        }
        if (in_array("compositions", $resourceTypes)) {
            $response["compositions"] = Composition::query()->orderByDesc("id")->get();
        }
        if (in_array("categories", $resourceTypes)) {
            $response["categories"] = Category::query()
                ->whereIn("name",["DESAYUNO","ALMUERZO","CENA"])
                ->orderBy("id","ASC")
                ->get();
        }

        return response()->json($response, Response::HTTP_OK);
    }
}
