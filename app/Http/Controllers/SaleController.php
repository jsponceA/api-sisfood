<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleFormRequest;
use App\Http\Traits\SaleTrait;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Worker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Symfony\Component\HttpFoundation\Response;

class SaleController extends Controller
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
            ->whereDate("sale_date",now()->format("Y-m-d"))
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

            $saleData["sale_date"] = now()->format("Y-m-d H:i:s");
            if ($saleData["deal_in_form"] == "DESCUENTO_PLANILLA"){
                $saleData["serie"] = "001";
                $saleData["num_document"] = Sale::query()->where("serie","001")->max("num_document") + 1;
                $saleData["pay_type"] = "CREDITO";
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
            $saleData = $request->except("sale_details");
            $saleDetailsData = $request->input("sale_details");
            $currentDay = now()->format("Y-m-d");
            $response = [];

            //validate worker
            $workerId = !empty($saleData["worker_id"]) ? $saleData["worker_id"] : null;
            $worker = Worker::query()->find($workerId);

            if (!empty($worker)){

                $searchSale = Sale::query()
                    ->with(["worker","saleDetails"])
                    ->where("serie","001")
                    ->where("deal_in_form","SUBVENCION")
                    ->where("worker_id",$worker->id)
                    ->whereDate("sale_date",$currentDay)
                    ->get();

                $product = Product::query()->findOrFail($saleData["product_id"]);


                $foodConsumed = null;
                $existsFoodType = false;
                foreach ($searchSale as $srSale) {
                    foreach ($srSale->saleDetails as $saleDetail) {
                        if ($saleDetail->product_id == $product->id){
                            $existsFoodType = true;
                            $foodConsumed = Sale::query()->find($saleDetail->sale_id);
                        }
                    }
                }



                if (empty($worker->breakfast) && mb_strtoupper($product->name) == "DESAYUNO"){
                    $response["error"] = true;
                    $response["alertType"] = 4;
                    $response["messageTile"] = "!El trabajador con DNI {$worker->numdoc} {$worker->names} {$worker->surnames}, no tienen acceso a {$product->name} ";
                    $response["messageContent"] = "";
                }elseif(empty($worker->lunch) && mb_strtoupper($product->name) == "ALMUERZO") {
                    $response["error"] = true;
                    $response["alertType"] = 4;
                    $response["messageTile"] = "!El trabajador con DNI {$worker->numdoc} {$worker->names} {$worker->surnames}, no tienen acceso a {$product->name} ";
                    $response["messageContent"] = "";
                }elseif(empty($worker->dinner) && mb_strtoupper($product->name) == "CENA") {
                    $response["error"] = true;
                    $response["alertType"] = 4;
                    $response["messageTile"] = "!El trabajador con DNI {$worker->numdoc} {$worker->names} {$worker->surnames}, no tienen acceso a {$product->name} ";
                    $response["messageContent"] = "";
                }elseif ($existsFoodType){
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
                $saleData["sale_date"] = now()->format("Y-m-d H:i:s");
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
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $sale = Sale::query()->findOrFail($id);

        return response()->json([
            "sale" => $sale
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaleFormRequest $request, int $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            /*$saleData = $request->except("sale_details");
            $saleDetailsData = collect($request->input("sale_details"));

            $sale = Sale::query()->findOrFail($id);
            $sale->update($saleData);

            //delete items not exists id
            $existsId = $saleDetailsData->map(fn($item)=>$item->id);
            $sale->saleDetails()->whereNotIn("id",$existsId)->delete();

            $saleDetail = $sale->saleDetails()->upsert($saleDetailsData,$existsId);*/

            DB::commit();
            return response()->json([
                "message" => "Venta modificado satisfactoriamente",
            ], Response::HTTP_OK);

        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json([
                "message" => "No ha sido posible modificar esta venta ocurrio el siguiente error {$e->getMessage()}",
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

            $nombreImpresora = env("PRINTER_NAME");
            $connector = new WindowsPrintConnector($nombreImpresora);
            //$connector = new FilePrintConnector(storage_path('app/simulated-print.txt'));
            $printer = new Printer($connector);

            $printer->initialize();
            # Vamos a alinear al centro lo próximo que imprimamos
            //$printer->setJustification(Printer::JUSTIFY_CENTER);

            /*try{
                $logo = EscposImage::load("/img/logolucemir.jpg", false);
                $printer->bitImage($logo);
            }catch(\Throwable $e){}*/

            /*
                Ahora vamos a imprimir un encabezado
            */

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->setFont(Printer::FONT_A);
            $printer->text("CONCESIONARIO DE ALIMENTOS LUCEMIR\n");
            $printer->text("\n");
            $printer->setFont(Printer::FONT_B);
            $printer->setEmphasis(false);
            $printer->text("TICKET: ".$sale->serie.'-'.Str::padLeft($sale->num_document,7,"0")."\n");
            $printer->setFont(Printer::FONT_B);
            $printer->text("FECHA Y HORA: ".now()->parse($sale->sale_date)->format("d/m/Y h:i:s A"). "\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("CAJERO: ".mb_strtoupper($user->username)."                  PEDIDOS: 92485988"."\n");
            $printer->text("COMENSAL: ".$comensal."\n");
            $printer->text("\n");

            //$printer->text("------------------------------------------------------------"."\n");
            //$printer->text("DESCRIPCIÓN  PRECIO."."\n");
            //$printer->text("------------------------------------------------------------"."\n");
            //$printer->selectPrintMode();
            //$printer->setEmphasis(false);
            $printer->setJustification(Printer::JUSTIFY_RIGHT);



            foreach ($sale->saleDetails as $detail) {
                //$productName = wordwrap($detail->product_name, 20, "\n", true); // Dividir en líneas de 20 caracteres
                $printer->text(number_format($detail->quantity)."x ".mb_strtoupper($detail->product_name)." "."S/ ".number_format($detail->sale_price,2)."      "."S/ ".number_format($detail->total,2)."\n");
            }

            //$printer->text("------------------------------------------------"."\n");

            # Para mostrar el total
            $total = $sale->total_sale;

            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text("------------"."\n");
            $printer->text("TOTAL: S/ ".number_format($total,2)."\n");
            $printer->text("FORMA DE PAGO: ".($sale->pay_type == "EFECTIVO" ? 'EFECTIVO' : 'Descuento por planilla') ."\n");

            /*Alimentamos el papel 3 veces*/
            $printer->feed(2);
            $printer->cut();
            $printer->pulse();
            $printer->close();

            return response()->json(["message" => "Impresion OK"],Response::HTTP_OK);
        }catch (\Throwable $t){
            return response()->json(["message" => $t->getMessage()],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Get All resource for all actions
     */

    public function getAllResources(Request $request): JsonResponse
    {
        //example resourceTypes => "table1,table2,table,etc..."
        $resourceTypes = explode(",", $request->input("resourceTypes"));

        $response = [];
        if (in_array("payTypes", $resourceTypes)) {
            $response["payTypes"] = ["CREDITO","EFECTIVO"];
        }
        if (in_array("foodTypes", $resourceTypes)) {
            $response["foodTypes"] = ["DESAYUNO","ALMUERZO","CENA"];
        }


        return response()->json($response, Response::HTTP_OK);
    }
}
