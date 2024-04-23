<?php

namespace App\Http\Traits;

use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait ConsumptionTrait
{
    public function queryList(Request $request)
    {
        $search = trim($request->input("search"));
        $dateStartConsumption = $request->input("dateStartConsumption");
        $dateEndConsumption = $request->input("dateEndConsumption");
        $categoryId = $request->input("categoryId");
        $typeFormId = $request->input("typeFormId");
        $areaId = $request->input("areaId");
        $typeDiscount = $request->input("typeDiscount");


        $sales = SaleDetail::query()
            ->with(["sale", "product"])
            ->whereHas("sale.worker", function ($query) use ($search, $typeFormId, $areaId) {
                $query
                    ->when(!empty($typeFormId), function ($query) use ($typeFormId) {
                        $query
                            ->where("type_form_id", $typeFormId);
                    })
                    ->when(!empty($areaId), function ($query) use ($areaId) {
                        $query
                            ->where("area_id", $areaId);
                    })
                    ->when(!empty($search), function ($query) use ($search) {
                        $query
                            ->where(function ($query) use ($search){
                                $query
                                    ->where("names", "LIKE", "%{$search}%")
                                    ->orWhere("surnames", "LIKE", "%{$search}%")
                                    ->orWhere("numdoc", "LIKE", "%{$search}%");
                            });
                    });
            })
            ->whereHas("sale", function ($query) use ($dateStartConsumption, $dateEndConsumption, $typeDiscount) {
                $query
                    ->when(!empty($typeDiscount), function ($query) use ($typeDiscount) {
                        $query->where("deal_in_form", $typeDiscount);
                    })
                    ->when(!empty($dateStartConsumption), function ($query) use ($dateStartConsumption) {
                        $query->whereDate("sale_date", ">=", $dateStartConsumption);
                    })
                    ->when(!empty($dateEndConsumption), function ($query) use ($dateEndConsumption) {
                        $query->whereDate("sale_date", "<=", $dateEndConsumption);
                    });
            })
            ->whereHas("product", function ($query) use ($categoryId) {
                $query->when(!empty($categoryId), function ($query) use ($categoryId) {
                    $query->where("category", $categoryId);
                });
            })
            ->orderByDesc("id");

        return $sales;
    }

    public function queryListSubvencion(Request $request)
    {
        $search = trim($request->input("search"));
        $dateStartConsumption = $request->input("dateStartConsumption");
        $dateEndConsumption = $request->input("dateEndConsumption");
        $categoryId = $request->input("categoryId");
        $typeFormId = $request->input("typeFormId");
        $areaId = $request->input("areaId");
        $typeDiscount = $request->input("typeDiscount");

        $sales = Sale::query()
            ->with(["worker","saleDetails"])
            ->when(!empty($typeDiscount), function ($query) use ($typeDiscount) {
                $query->where("deal_in_form", $typeDiscount);
            })
            ->when(!empty($dateStartConsumption), function ($query) use ($dateStartConsumption) {
                $query->whereDate("sale_date", ">=", $dateStartConsumption);
            })
            ->when(!empty($dateEndConsumption), function ($query) use ($dateEndConsumption) {
                $query->whereDate("sale_date", "<=", $dateEndConsumption);
            })
            ->whereHas("worker", function ($query) use ($search, $typeFormId, $areaId) {
                $query
                    ->when(!empty($typeFormId), function ($query) use ($typeFormId) {
                        $query
                            ->where("type_form_id", $typeFormId);
                    })
                    ->when(!empty($areaId), function ($query) use ($areaId) {
                        $query
                            ->where("area_id", $areaId);
                    })
                    ->when(!empty($search), function ($query) use ($search) {
                        $query
                            ->where(function ($query) use ($search){
                                $query
                                    ->where("names", "LIKE", "%{$search}%")
                                    ->orWhere("surnames", "LIKE", "%{$search}%")
                                    ->orWhere("numdoc", "LIKE", "%{$search}%");
                            });
                    });
            })
            ->whereHas("saleDetails.product", function ($query) use ($categoryId) {
                $query->when(!empty($categoryId), function ($query) use ($categoryId) {
                    $query->where("category", $categoryId);
                });
            })
            ->orderByDesc("sale_date")
            ->orderByDesc("id");

        return $sales;
    }


    public function queryListConsumption(Request $request)
    {
        $search = trim($request->input("search"));
        $dateStartConsumption = $request->input("dateStartConsumption");
        $dateEndConsumption = $request->input("dateEndConsumption");
        $categoryId = $request->input("categoryId");
        $typeFormId = $request->input("typeFormId");
        $areaId = $request->input("areaId");
        $typeDiscount = $request->input("typeDiscount");


        $sales = Sale::query()
            ->with(["worker","saleDetails"])
            ->where("deal_in_form","DESCUENTO_PLANILLA")
            ->when(!empty($dateStartConsumption), function ($query) use ($dateStartConsumption) {
                $query->whereDate("sale_date", ">=", $dateStartConsumption);
            })
            ->when(!empty($dateEndConsumption), function ($query) use ($dateEndConsumption) {
                $query->whereDate("sale_date", "<=", $dateEndConsumption);
            })
            ->whereHas("worker", function ($query) use ($search, $typeFormId, $areaId) {
                $query
                    ->when(!empty($typeFormId), function ($query) use ($typeFormId) {
                        $query
                            ->where("type_form_id", $typeFormId);
                    })
                    ->when(!empty($areaId), function ($query) use ($areaId) {
                        $query
                            ->where("area_id", $areaId);
                    })
                    ->when(!empty($search), function ($query) use ($search) {
                        $query
                            ->where(function ($query) use ($search){
                                $query
                                    ->where("names", "LIKE", "%{$search}%")
                                    ->orWhere("surnames", "LIKE", "%{$search}%")
                                    ->orWhere("numdoc", "LIKE", "%{$search}%");
                            });
                    });
            })
            ->whereHas("saleDetails.product", function ($query) use ($categoryId) {
                $query->when(!empty($categoryId), function ($query) use ($categoryId) {
                    $query->where("category", $categoryId);
                });
            })
            ->orderByDesc("id");

        return $sales;
    }

    public function queryListWorkerSummany(Request $request)
    {
        $search = trim($request->input("search"));
        $dateStartConsumption = $request->input("dateStartConsumption");
        $dateEndConsumption = $request->input("dateEndConsumption");
        $categoryId = $request->input("categoryId");
        $typeFormId = $request->input("typeFormId");
        $areaId = $request->input("areaId");
        $typeDiscount = $request->input("typeDiscount");


        $sales = Sale::query()
            ->with(["worker","saleDetails"])
            ->join("sale_details","sales.id","=","sale_details.sale_id")
            ->select("worker_id",DB::raw("
            SUM( CASE WHEN sale_details.product_name='DESAYUNO' THEN sale_details.quantity ELSE 0 END) AS total_desayunos,
            SUM( CASE WHEN sale_details.product_name='ALMUERZO' THEN sale_details.quantity ELSE 0 END) AS total_almuerzos,
            SUM( CASE WHEN sale_details.product_name='CENA' THEN sale_details.quantity ELSE 0 END) AS total_cenas,
            SUM( CASE WHEN sale_details.product_name='DESAYUNO' THEN sale_details.total ELSE 0 END) AS monto_desayunos,
            SUM( CASE WHEN sale_details.product_name='ALMUERZO' THEN sale_details.total ELSE 0 END) AS  monto_almuerzos,
            SUM( CASE WHEN sale_details.product_name='CENA' THEN sale_details.total ELSE 0 END) AS  monto_cenas,
            SUM( CASE WHEN sale_details.product_name != 'DESAYUNO' AND sale_details.product_name != 'ALMUERZO' AND sale_details.product_name != 'CENA' THEN sale_details.total ELSE 0 END) AS monto_snacks
            "))
            ->when(!empty($typeDiscount), function ($query) use ($typeDiscount) {
                $query->where("deal_in_form", $typeDiscount);
            })
            ->when(!empty($dateStartConsumption), function ($query) use ($dateStartConsumption) {
                $query->whereDate("sale_date", ">=", $dateStartConsumption);
            })
            ->when(!empty($dateEndConsumption), function ($query) use ($dateEndConsumption) {
                $query->whereDate("sale_date", "<=", $dateEndConsumption);
            })
            ->whereHas("worker", function ($query) use ($search, $typeFormId, $areaId) {
                $query
                    ->when(!empty($typeFormId), function ($query) use ($typeFormId) {
                        $query
                            ->where("type_form_id", $typeFormId);
                    })
                    ->when(!empty($areaId), function ($query) use ($areaId) {
                        $query
                            ->where("area_id", $areaId);
                    })
                    ->when(!empty($search), function ($query) use ($search) {
                        $query
                            ->where(function ($query) use ($search){
                                $query
                                    ->where("names", "LIKE", "%{$search}%")
                                    ->orWhere("surnames", "LIKE", "%{$search}%")
                                    ->orWhere("numdoc", "LIKE", "%{$search}%");
                            });
                    });
            })
            ->whereHas("saleDetails.product", function ($query) use ($categoryId) {
                $query->when(!empty($categoryId), function ($query) use ($categoryId) {
                    $query->where("category", $categoryId);
                });
            })
            ->groupBy("worker_id");
            //->orderBy("id");

        return $sales;
    }
}
