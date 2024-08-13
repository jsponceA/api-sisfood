<?php

namespace App\Http\Controllers;



use App\Http\Traits\SaleTrait;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Worker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Symfony\Component\HttpFoundation\Response;

class PastSaleController extends Controller
{
    use SaleTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $page = $request->input("page");
        $perPage = $request->input("perPage");
        $search = trim($request->input("search"));
        $workerId = $request->input("workerId");

        $sales = Sale::query()
            ->with(["worker","saleDetails"])
            ->when(!empty($search), function ($q) use ($search) {
                $q->where(DB::raw("CONCAT(serie,'-',num_document)"), "LIKE", "%{$search}%");
            })
            //->where("serie","001")
            //->where("deal_in_form","SUBVENCION")
            //->where("worker_id",$workerId)
            //->whereDate("sale_date",now()->format("Y-m-d"))
            ->orderByDesc("id")
            ->paginate($perPage, ["*"], "page", $page);

        return response()->json([
            "sales" => $sales
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $saleData = $request->except("sale_details");
            $saleDetailsData = $request->input("sale_details");

            /*ESTO ES IMPORTANTE*/
            $currentDay = $saleData["sale_date"];
            $saleData["created_at"] = $currentDay;
            $saleData["updated_at"] = $currentDay;
            /*ESTO ES IMPORTANTE*/


            if ($saleData["deal_in_form"] == "DESCUENTO_PLANILLA"){
                $saleData["serie"] = "001";
                $saleData["num_document"] = Sale::query()->where("serie","001")->max("num_document") + 1;
                $saleData["pay_type"] = "CREDITO";
                $saleData["total_dsct_form"] = 0;
                $saleData["total_pay_company"] = 0;
                $saleData["total_igv"] = 0;
            }else{
                $saleData["serie"] = "002";
                $saleData["num_document"] = Sale::query()->where("serie","002")->max("num_document") + 1;
                $saleData["pay_type"] = "EFECTIVO";
                $saleData["total_dsct_form"] = 0;
                $saleData["total_pay_company"] = 0;
                $saleData["total_igv"] = 0;
            }
            $sale = Sale::query()->create($saleData);
            $sale->saleDetails()->createMany($saleDetailsData);

            DB::commit();
            return response()->json(["message" => "venta creada satisfactoriamente","sale" => $sale], Response::HTTP_CREATED);

        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json([
                "message" => "No ha sido posible crear esta venta ocurrio el siguiente error {$e->getMessage()}",
            ], Response::HTTP_BAD_REQUEST);
        }

    }
    public function subVencionStore(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $searchWorker = $request->input("searchWorker");
            $selectedFoodType = $request->input("selectedFoodType");
            $saleData = $request->except("sale_details");
            $saleDetailsData = $request->input("sale_details");

            /*ESTO ES IMPORTANTE*/
            $currentDay = $saleData["sale_date"];
            $saleData["created_at"] = $currentDay;
            $saleData["updated_at"] = $currentDay;
            /*ESTO ES IMPORTANTE*/
            $response = [];

            //validate worker
            $worker = Worker::query()->find($saleData["worker_id"] ?? null);

            if (!empty($worker)){

                $searchSale = Sale::query()
                    ->with(["worker","saleDetails"])
                    ->where("serie","001")
                    ->where("deal_in_form","SUBVENCION")
                    ->where("worker_id",$worker->id)
                    ->whereDate("sale_date",now()->parse($currentDay)->format("Y-m-d"))
                    ->get();

                $product = Product::query()->findOrFail($saleDetailsData[0]["product_id"]);
                $category = Category::query()->where("name",$selectedFoodType)->first();


                $foodConsumed = null;
                $existsFoodType = false;
                foreach ($searchSale as $srSale) {
                    foreach ($srSale->saleDetails as $saleDetail) {
                        /*if ($saleDetail->product_id == $product->id){
                           $existsFoodType = true;
                           $foodConsumed = Sale::query()->find($saleDetail->sale_id);
                       }*/
                        if ($saleDetail->product->category_id == $category->id){
                            $existsFoodType = true;
                            $foodConsumed = Sale::query()->find($saleDetail->sale_id);
                        }
                    }
                }



                if($worker->terminated_worker){
                    $suspendDateFormat = now()->parse($worker->suspension_date)->format("d/m/Y");
                    $response["error"] = true;
                    $response["alertType"] = 4;
                    $response["messageTile"] = "!El trabajador con DNI {$worker->numdoc} {$worker->names} {$worker->surnames}, ya fue cesado en la fecha {$suspendDateFormat} ";
                    $response["messageContent"] = "";
                }else if(!in_array($category->id,$worker->allowed_meals)){
                    $response["error"] = true;
                    $response["alertType"] = 4;
                    $response["messageTile"] = "!El trabajador con DNI {$worker->numdoc} {$worker->names} {$worker->surnames}, no tienen acceso a {$product->name} ";
                    $response["messageContent"] = "";
                }elseif ($existsFoodType ){
                    $response["error"] = true;
                    $response["alertType"] = 2;
                    $response["messageTile"] = "!El trabajador con DNI {$worker->numdoc} {$worker->names} {$worker->surnames}, ya consumio su {$product->name} el ".now()->parse($foodConsumed->sale_date)->format("d/m/Y h:i:s A");
                    $response["messageContent"] = "";
                }else{
                    $response["error"] = false;
                    $response["alertType"] = 1;
                    $response["messageTile"] = "!Hola {$worker->names} {$worker->surnames}, se registro su {$product->name} con éxito¡";
                    $response["messageContent"] = "Retire los tickets y pase a comedor, Gracias !";
                }

            }else{
                $response["error"] = true;
                $response["alertType"] = 3;
                $response["messageTile"] = "!El trabajador con DNI {$searchWorker}, no esta registrado¡";
                $response["messageContent"] = "Comunicarse con RR.HH para su activación en el sistema. Gracias";
            }

            //success - create sale and details
            if (empty($response["error"])){

                $saleData["deal_in_form"] = "SUBVENCION";
                $saleData["pay_type"] = "CREDITO";
                $saleData["serie"] = "001";
                $saleData["num_document"] = Sale::query()->where("serie","001")->max("num_document") + 1;

                $sale = Sale::query()->create($saleData);
                $sale->saleDetails()->createMany($saleDetailsData);
                $response["id"] = $sale->id;
            }

            DB::commit();
            return response()->json($response, Response::HTTP_CREATED);

        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json([
                "message" => "No ha sido posible crear esta venta ocurrio el siguiente error {$e->getMessage()}",
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $sale = Sale::query()->findOrFail($id);
        $sale->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }


    public function generateTicket(Request $request)
    {
        try {
            $sale = Sale::query()
                ->with(["worker","saleDetails"])
                ->findOrFail($request->input("id"));
            $user = auth()->user();

            //variables
            $comensal = !empty($sale->worker->names) ? mb_strtoupper($sale->worker->names." ".$sale->worker->surnames) : 'PUBLICO GENERAL';

            $nombreImpresora = config("printerticket.name");
            $connector = new WindowsPrintConnector($nombreImpresora);
            //$connector = new FilePrintConnector(storage_path('app/simulated-print.txt'));
            $printer = new Printer($connector);

            $printer->initialize();
            # Vamos a alinear al centro lo próximo que imprimamos
            //$printer->setJustification(Printer::JUSTIFY_CENTER);
            //$printer->selectPrintMode(Printer::MODE_FONT_B);
            //$printer->setTextSize(2,1);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->setFont(Printer::FONT_A);
            $printer->text("CONCESIONARIO DE ALIMENTOS LUCEMIR");
            $printer->text("\n");
            $printer->setFont(Printer::FONT_B);
            $printer->setEmphasis(false);
            $printer->text("TICKET: ".$sale->serie.'-'.Str::padLeft($sale->num_document,7,"0")."\n");
            $printer->setFont(Printer::FONT_B);
            $printer->text("FECHA Y HORA: ".now()->parse($sale->sale_date)->format("d/m/Y h:i A"). "\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("CAJERO: ".mb_strtoupper($user->username)."\n");
            $printer->text("PEDIDOS: 924859988\n");
            $printer->text("COMENSAL: ".$comensal."\n");
            $printer->text("\n");

            //$printer->text("------------------------------------------------------------"."\n");
            //$printer->text("DESCRIPCIÓN  PRECIO."."\n");
            //$printer->text("------------------------------------------------------------"."\n");
            //$printer->selectPrintMode();
            //$printer->setEmphasis(false);
            $printer->setJustification(Printer::JUSTIFY_RIGHT);



            $printer->setEmphasis(true);
            $printer->setTextSize(2,1);
            foreach ($sale->saleDetails as $detail) {
                //$productName = wordwrap($detail->product_name, 20, "\n", true); // Dividir en líneas de 20 caracteres
                $printer->text(number_format($detail->quantity)."x ".mb_strtoupper($detail->product_name)." "."S/ ".number_format($detail->sale_price,2)."      "."S/ ".number_format($detail->total,2)."\n");
            }
            $printer->setTextSize(1,1);
            $printer->setEmphasis(false);
            //$printer->text("------------------------------------------------"."\n");

            # Para mostrar el total
            $total = $sale->total_sale;

            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("------------"."\n");
            $printer->text("TOTAL: S/ ".number_format($total,2)."\n");
            $printer->text(" \n");
            $printer->text("FORMA DE PAGO: ".($sale->pay_type == "EFECTIVO" ? 'EFECTIVO' : 'Descuento por planilla') ."\n");

            $printer->feed(2);
            $printer->cut();
            $printer->pulse();
            $printer->close();

            return response()->json(["message" => "Impresion OK"],Response::HTTP_OK);
        }catch (\Throwable $t){
            return response()->json(["message" => $t->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }


    public function getAllResources(Request $request): JsonResponse
    {
        //example resourceTypes => "table1,table2,table,etc..."
        $resourceTypes = explode(",", $request->input("resourceTypes"));

        $response = [];
        if (in_array("payTypes", $resourceTypes)) {
            $response["payTypes"] = ["CREDITO","EFECTIVO"];
        }
        if (in_array("foodTypes", $resourceTypes)) {
            $response["foodTypes"] = Category::query()
                ->whereIn("name",["DESAYUNO","ALMUERZO","CENA"])
                ->orderBy("id","ASC")
                ->get();
        }


        return response()->json($response, Response::HTTP_OK);
    }
}

