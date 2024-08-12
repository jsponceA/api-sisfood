<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
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
        $categoryId = $request->input("category_id");

        $sales = Product::query()
            ->selectRaw("SUM(sd.quantity) AS quantityProducts,
            SUM(s.total_sale) AS totalSale,
            SUM(s.total_pay_company) AS totalSaleCompany,
            products.name AS product_name,
            categories.name AS category_name
            ")
            ->join("categories","products.category_id","=","categories.id")
            ->join("sale_details AS sd","products.id","=","sd.product_id")
            ->join("sales AS s","sd.sale_id","=","s.id")
            ->leftJoin("workers as w","s.worker_id","=","w.id")
            ->whereNull("s.deleted_at")
            ->when(!empty($starDate),fn($q) => $q->whereDate("s.sale_date",">=",$starDate))
            ->when(!empty($endDate),fn($q) => $q->whereDate("s.sale_date","<=",$endDate))
            ->when(!empty($categoryId),fn($q) => $q->where("category_id",$categoryId))
            ->groupBy("products.name","category_name")
            ->get();


        $linearDataResult = [];
        $rangeDates = CarbonPeriod::create($starDate,$endDate)->toArray();
        foreach ($rangeDates as $rdate) {
            $linearDataResult["labels"][] = ucfirst($rdate->dayName).' - '.$rdate->format("d/m/Y");
        }

        foreach ($rangeDates as $dateLabel) {
            $linearDataResult["data_desayuno"][] = Product::query()
                ->leftJoin("sale_details AS sd","products.id","=","sd.product_id")
                ->leftJoin("sales AS s","sd.sale_id","=","s.id")
                ->leftJoin("categories","products.category_id","=","categories.id")
                ->whereNull("s.deleted_at")
                ->whereDate("s.sale_date",$dateLabel)
                ->where("categories.name","DESAYUNO")
                ->sum("sd.quantity");

            $linearDataResult["data_almuerzo"][] = Product::query()
                ->leftJoin("sale_details AS sd","products.id","=","sd.product_id")
                ->leftJoin("sales AS s","sd.sale_id","=","s.id")
                ->leftJoin("categories","products.category_id","=","categories.id")
                ->whereNull("s.deleted_at")
                ->whereDate("s.sale_date",$dateLabel)
                ->where("categories.name","ALMUERZO")
                ->sum("sd.quantity");

            $linearDataResult["data_cena"][] = Product::query()
                ->leftJoin("sale_details AS sd","products.id","=","sd.product_id")
                ->leftJoin("sales AS s","sd.sale_id","=","s.id")
                ->leftJoin("categories","products.category_id","=","categories.id")
                ->whereNull("s.deleted_at")
                ->whereDate("s.sale_date",$dateLabel)
                ->where("categories.name","CENA")
                ->sum("sd.quantity");
        }

        $categorysFilter = ["BEBIDAS","SNACK","EXTRAS"];
        $pieDataResult = [];
        foreach ($categorysFilter as $cat) {
            $pieDataResult[] = Product::query()
                ->leftJoin("sale_details AS sd","products.id","=","sd.product_id")
                ->leftJoin("sales AS s","sd.sale_id","=","s.id")
                ->leftJoin("categories","products.category_id","=","categories.id")
                ->whereNull("s.deleted_at")
                ->when(!empty($starDate),fn($q) => $q->whereDate("s.sale_date",">=",$starDate))
                ->when(!empty($endDate),fn($q) => $q->whereDate("s.sale_date","<=",$endDate))
                ->where("categories.name",$cat)
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
                ->leftJoin("categories","products.category_id","=","categories.id")
                ->whereNull("s.deleted_at")
                ->whereMonth("s.sale_date",$dateLabel)
                ->whereYear("s.sale_date",$dateLabel)
                ->where("categories.name","ALMUERZO")
                ->sum("sd.quantity");

            $barDataResult["data_almuerzo"][] = Product::query()
                ->leftJoin("sale_details AS sd","products.id","=","sd.product_id")
                ->leftJoin("sales AS s","sd.sale_id","=","s.id")
                ->leftJoin("categories","products.category_id","=","categories.id")
                ->whereNull("s.deleted_at")
                ->whereMonth("s.sale_date",$dateLabel)
                ->whereYear("s.sale_date",$dateLabel)
                ->where("categories.name","ALMUERZO")
                ->sum("sd.quantity");

            $barDataResult["data_cena"][] = Product::query()
                ->leftJoin("sale_details AS sd","products.id","=","sd.product_id")
                ->leftJoin("sales AS s","sd.sale_id","=","s.id")
                ->leftJoin("categories","products.category_id","=","categories.id")
                ->whereNull("s.deleted_at")
                ->whereMonth("s.sale_date",$dateLabel)
                ->whereYear("s.sale_date",$dateLabel)
                ->where("categories.name","ALMUERZO")
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
            $response["categories"] = Category::query()
                //->whereIn("name",["DESAYUNO","ALMUERZO","CENA"])
                ->orderBy("id","ASC")
                ->get();
        }

        return response()->json($response, Response::HTTP_OK);
    }
}
