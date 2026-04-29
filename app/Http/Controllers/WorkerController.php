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
use App\Models\Managent;
use App\Models\OrganizationalUnit;
use App\Models\PayrollArea;
use App\Models\StaffDivision;
use App\Models\Superior;
use App\Models\TypeDocument;
use App\Models\TypeForm;
use App\Models\Worker;
use App\Models\WorkerFingerprint;
use App\Models\WorkerType;
use App\Services\BiometricTemplateService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
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
        $data = $request->validated();
        $fingerprints = $data["fingerprints"] ?? [];
        unset($data["fingerprints"]);

        return DB::transaction(function () use ($request, $data, $fingerprints) {
            if ($request->hasFile("photo")) {
                $data["photo"] = basename($request->file("photo")->store("workers"));
            }

            $worker = Worker::query()->create($data);
            $this->syncFingerprints($worker, $fingerprints);
            $this->scheduleFingerprintTemplateWarmup($worker->id);

            return response()->json([
                "message" => "Trabajador creado satisfactoriamente"
            ], Response::HTTP_CREATED);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $worker = Worker::query()
            ->with("fingerprints")
            ->withCount("fingerprints")
            ->findOrFail($id);

        return response()->json([
            "worker" => $worker
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkerFormRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $fingerprints = $data["fingerprints"] ?? [];
        unset($data["fingerprints"]);

        return DB::transaction(function () use ($request, $id, $data, $fingerprints) {
            $worker = Worker::query()->findOrFail($id);

            if ($request->hasFile("photo")) {
                Storage::delete("workers/{$worker->photo}");
                $data["photo"] = basename($request->file("photo")->store("workers"));
            }

            $worker->update($data);
            $this->syncFingerprints($worker, $fingerprints);
            $this->scheduleFingerprintTemplateWarmup($worker->id);

            return response()->json([
                "message" => "Trabajador modificado satisfactoriamente"
            ], Response::HTTP_OK);
        });
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

    public function identifyFingerprint(Request $request): JsonResponse
    {
        if (function_exists('set_time_limit')) {
            @set_time_limit(max((int) config("services.biometric.timeout", 120) + 15, 180));
        }

        $data = $request->validate([
            "sample_data" => ["nullable", "string"],
            "image_data" => ["nullable", "string"],
        ]);

        if (blank($data["sample_data"] ?? null) && blank($data["image_data"] ?? null)) {
            return response()->json([
                "matched" => false,
                "message" => "No se recibió una huella válida para comparar."
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $fingerprints = WorkerFingerprint::query()
            ->with(["worker.area"])
            ->select([
                "id",
                "worker_id",
                "finger_label",
                "image_data",
                "sample_data",
                "capture_metadata",
            ])
            ->whereNotNull("image_data")
            ->get();

        if ($fingerprints->isEmpty()) {
            return response()->json([
                "matched" => false,
                "message" => "No hay huellas registradas para comparar."
            ], Response::HTTP_OK);
        }

        $serviceUrl = rtrim((string) config("services.biometric.url"), "/");
        $biometricTemplateService = app(BiometricTemplateService::class);
        $biometricTemplateService->hydrateTemplates($fingerprints, $serviceUrl);

        try {
            $response = Http::connectTimeout(5)
                ->timeout((int) config("services.biometric.timeout", 120))
                ->acceptJson()
                ->post("{$serviceUrl}/identify", [
                    "image_data" => $data["image_data"] ?? null,
                    "score_threshold" => (float) config("services.biometric.score_threshold", 30),
                    "candidates" => $fingerprints->map(fn(WorkerFingerprint $fingerprint) => $biometricTemplateService->buildCandidatePayload($fingerprint))->values()->all(),
                ]);
        } catch (\Throwable $exception) {
            return response()->json([
                "matched" => false,
                "message" => "No se pudo conectar con el servicio biométrico local. Inícialo y vuelve a intentar.",
                "error" => $exception->getMessage(),
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        if ($response->failed()) {
            return response()->json([
                "matched" => false,
                "message" => "El servicio biométrico respondió con error.",
                "error" => $response->json("detail") ?: $response->body(),
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        $result = $response->json();
        $bestMatch = $result["best_match"] ?? null;

        if (!($result["matched"] ?? false) || empty($bestMatch["worker_id"])) {
            return response()->json([
                "matched" => false,
                "message" => ($result["ambiguous"] ?? false)
                    ? ($result["message"] ?? "La huella coincide con más de un trabajador y no se pudo decidir con suficiente seguridad.")
                    : ($result["message"] ?? "No se encontró un trabajador con una coincidencia suficiente."),
                "biometric" => $result["best_attempt"] ?? null,
                "best_worker_attempt" => $result["best_worker_attempt"] ?? null,
                "second_best_worker_attempt" => $result["second_best_worker_attempt"] ?? null,
                "ambiguous" => (bool) ($result["ambiguous"] ?? false),
                "candidate_count" => $result["candidate_count"] ?? $fingerprints->count(),
            ], Response::HTTP_OK);
        }

        $workerFingerprint = $fingerprints->first(function (WorkerFingerprint $fingerprint) use ($bestMatch) {
            return (int) $fingerprint->worker_id === (int) $bestMatch["worker_id"];
        });

        if (!$workerFingerprint || !$workerFingerprint->worker) {
            return response()->json([
                "matched" => false,
                "message" => "La huella coincidió, pero no se pudo cargar el trabajador relacionado.",
                "biometric" => $bestMatch,
            ], Response::HTTP_OK);
        }

        return response()->json([
            "matched" => true,
            "worker" => $workerFingerprint->worker,
            "biometric" => $bestMatch,
            "candidate_count" => $result["candidate_count"] ?? $fingerprints->count(),
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
                ->whereIn("name", ["DESAYUNO", "ALMUERZO", "CENA", "LONCHE"])
                ->orderBy("id", "ASC")
                ->get();
        }
        if (in_array("workerTypes", $resourceTypes)) {
            $response["workerTypes"] = WorkerType::query()
                ->orderByDesc("id")
                ->get();
        }

        if (in_array("managents", $resourceTypes)) {
            $response["managents"] = Managent::query()
                ->orderByDesc("id")
                ->get();
        }

        return response()->json($response, Response::HTTP_OK);
    }

    private function syncFingerprints(Worker $worker, array $fingerprints): void
    {
        $worker->fingerprints()->forceDelete();

        if (empty($fingerprints)) {
            return;
        }

        $worker->fingerprints()->createMany(array_map(function ($fingerprint) {
            return [
                "finger_label" => $fingerprint["finger_label"] ?? null,
                "sample_format" => $fingerprint["sample_format"],
                "sample_data" => $fingerprint["sample_data"],
                "image_data" => $fingerprint["image_data"] ?? null,
                "device_uid" => $fingerprint["device_uid"] ?? null,
                "quality" => $fingerprint["quality"] ?? null,
                "capture_metadata" => $fingerprint["capture_metadata"] ?? null,
            ];
        }, $fingerprints));
    }

    private function scheduleFingerprintTemplateWarmup(int $workerId): void
    {
        $warmTemplates = function () use ($workerId) {
            try {
                app(BiometricTemplateService::class)->hydrateWorkerFingerprints($workerId);
            } catch (\Throwable) {
                // Si el servicio biométrico no está disponible, la huella se calentará en la primera búsqueda o con el comando manual.
            }
        };

        $scheduleAfterCommit = function () use ($warmTemplates) {
            if (app()->runningInConsole()) {
                $warmTemplates();
                return;
            }

            app()->terminating($warmTemplates);
        };

        if (DB::transactionLevel() > 0) {
            DB::afterCommit($scheduleAfterCommit);
            return;
        }

        $scheduleAfterCommit();
    }
}
