<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function getSalesProductCount(Request $request)
    {
        $starDate = $request->input("startDate");
        $endDate = $request->input("endDate");
        $category = $request->input("category");

        $sales = Product::query()
            ->selectRaw("name,category,SUM(sd.quantity) AS quantityProducts,SUM(s.total_sale) AS totalSale")
            ->leftJoin("sale_details AS sd","products.id","=","sd.product_id")
            ->leftJoin("sales AS s","sd.sale_id","=","s.id")
            ->when(!empty($starDate),fn($q) => $q->whereDate("s.sale_date",">=",$starDate))
            ->when(!empty($endDate),fn($q) => $q->whereDate("s.sale_date","<=",$endDate))
            ->when(!empty($category),fn($q) => $q->where("category",$category))
            ->groupBy("name","category")
            ->get();

        $linearDataResult = [];
        $rangeDates = CarbonPeriod::create($starDate,$endDate)->toArray();
        foreach ($rangeDates as $rdate) {
            $linearDataResult["labels"][] = $rdate->format("d/m/Y");
        }

        foreach ($rangeDates as $dateLabel) {
            $linearDataResult["data_desayuno"][] = Product::query()
                ->leftJoin("sale_details AS sd","products.id","=","sd.product_id")
                ->leftJoin("sales AS s","sd.sale_id","=","s.id")
                ->whereDate("s.sale_date",$dateLabel)
                ->where("category","COMIDAS")
                ->where("name","DESAYUNO")
                ->sum("sd.quantity");

            $linearDataResult["data_almuerzo"][] = Product::query()
                ->leftJoin("sale_details AS sd","products.id","=","sd.product_id")
                ->leftJoin("sales AS s","sd.sale_id","=","s.id")
                ->whereDate("s.sale_date",$dateLabel)
                ->where("category","COMIDAS")
                ->where("name","ALMUERZO")
                ->sum("sd.quantity");

            $linearDataResult["data_cena"][] = Product::query()
                ->leftJoin("sale_details AS sd","products.id","=","sd.product_id")
                ->leftJoin("sales AS s","sd.sale_id","=","s.id")
                ->whereDate("s.sale_date",$dateLabel)
                ->where("category","COMIDAS")
                ->where("name","CENA")
                ->sum("sd.quantity");
        }

        $categorysFilter = ["BEBIDAS","SNACK","EXTRAS"];
        $pieDataResult = [];
        foreach ($categorysFilter as $cat) {
            $pieDataResult[] = Product::query()
                ->leftJoin("sale_details AS sd","products.id","=","sd.product_id")
                ->leftJoin("sales AS s","sd.sale_id","=","s.id")
                ->when(!empty($starDate),fn($q) => $q->whereDate("s.sale_date",">=",$starDate))
                ->when(!empty($endDate),fn($q) => $q->whereDate("s.sale_date","<=",$endDate))
                ->where("category",$cat)
                ->sum("sd.quantity");
        }


        /**********/
        $barDataResult = [];
        $rangeDatesMonths = CarbonPeriod::create(now()->subMonths(12)->format("Y-m-d"),'1 month',now()->format("Y-m-d"))->toArray();
        foreach ($rangeDatesMonths as $rdate) {
            $barDataResult["labels"][] = ucfirst($rdate->monthName);
        }

        foreach ($rangeDatesMonths as $dateLabel) {
            $barDataResult["data_desayuno"][] = Product::query()
                ->leftJoin("sale_details AS sd","products.id","=","sd.product_id")
                ->leftJoin("sales AS s","sd.sale_id","=","s.id")
                ->whereMonth("s.sale_date",$dateLabel)
                ->where("category","COMIDAS")
                ->where("name","DESAYUNO")
                ->sum("sd.quantity");

            $barDataResult["data_almuerzo"][] = Product::query()
                ->leftJoin("sale_details AS sd","products.id","=","sd.product_id")
                ->leftJoin("sales AS s","sd.sale_id","=","s.id")
                ->whereMonth("s.sale_date",$dateLabel)
                ->where("category","COMIDAS")
                ->where("name","ALMUERZO")
                ->sum("sd.quantity");

            $barDataResult["data_cena"][] = Product::query()
                ->leftJoin("sale_details AS sd","products.id","=","sd.product_id")
                ->leftJoin("sales AS s","sd.sale_id","=","s.id")
                ->whereMonth("s.sale_date",$dateLabel)
                ->where("category","COMIDAS")
                ->where("name","CENA")
                ->sum("sd.quantity");
        }



        return response()->json([
            "sales" => $sales,
            "linearDataResult" => $linearDataResult,
             "pieDataResul" => $pieDataResult,
            "barDataResult" => $barDataResult
        ],Response::HTTP_OK);
    }

    public function getAllResources(Request $request): JsonResponse
    {
        //example resourceTypes => "table1,table2,table,etc..."
        $resourceTypes = explode(",", $request->input("resourceTypes"));

        $response = [];
        if (in_array("categories", $resourceTypes)) {
            $response["categories"] = ["BEBIDAS","COMIDAS","SNACK","EXTRAS"];
        }

        return response()->json($response, Response::HTTP_OK);
    }
}
