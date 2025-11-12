<?php

namespace App\Http\Traits;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Holidays\Holidays;

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
        $workerTypeId = $request->input("worker_type_id");


        $sales = SaleDetail::query()
            ->with(["sale", "product"])
            ->whereHas("sale.worker", function ($query) use ($search, $typeFormId, $areaId,$workerTypeId) {
                $query
                    ->when(!empty($typeFormId), function ($query) use ($typeFormId) {
                        $query
                            ->where("type_form_id", $typeFormId);
                    })
                    ->when(!empty($areaId), function ($query) use ($areaId) {
                        $query
                            ->where("area_id", $areaId);
                    })
                    ->when(!empty($workerTypeId), function ($query) use ($workerTypeId) {
                        $query
                            ->where("worker_type_id", $workerTypeId);
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
                    $query->where("category_id", $categoryId);
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
        $workerTypeId = $request->input("worker_type_id");

        // Array de días feriados (formato: 'Y-m-d')
        $holidaysData = Holidays::for(country: 'pe')->get(year: now()->format('Y'));
        $holidays = array_map(function($holiday) {
            return \Carbon\Carbon::parse($holiday['date'])->format('Y-m-d');
        }, $holidaysData);


        $sales = Sale::query()
            ->with(["worker","saleDetails"])
            ->whereNot('deal_in_form', 'NO_DESCONTAR')
            // Excluir domingos (DAYOFWEEK: 1=Domingo, 7=Sábado en MySQL)
            ->whereRaw('DAYOFWEEK(sale_date) != 1')
            // Excluir días feriados si hay alguno definido
            ->when(!empty($holidays), function ($query) use ($holidays) {
                $query->whereNotIn(DB::raw('DATE(sale_date)'), $holidays);
            })
            ->when(!empty($typeDiscount), function ($query) use ($typeDiscount) {
                $query->where("deal_in_form", $typeDiscount);
            })
            ->when(!empty($dateStartConsumption), function ($query) use ($dateStartConsumption) {
                $query->whereDate("sale_date", ">=", $dateStartConsumption);
            })
            ->when(!empty($dateEndConsumption), function ($query) use ($dateEndConsumption) {
                $query->whereDate("sale_date", "<=", $dateEndConsumption);
            })
            ->whereHas("worker", function ($query) use ($search, $typeFormId, $areaId,$workerTypeId) {
                $query
                    ->when(!empty($typeFormId), function ($query) use ($typeFormId) {
                        $query
                            ->where("type_form_id", $typeFormId);
                    })
                    ->when(!empty($areaId), function ($query) use ($areaId) {
                        $query
                            ->where("area_id", $areaId);
                    })
                    ->when(!empty($workerTypeId), function ($query) use ($workerTypeId) {
                        $query
                            ->where("worker_type_id", $workerTypeId);
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

    public function queryListSubvencionPerDay(Request $request)
    {
        $search = trim($request->input("search"));
        $dateStartConsumption = $request->input("dateStartConsumption");
        $dateEndConsumption = $request->input("dateEndConsumption");
        $categoryId = $request->input("categoryId");
        $typeFormId = $request->input("typeFormId");
        $areaId = $request->input("areaId");
        $typeDiscount = $request->input("typeDiscount");
        $workerTypeId = $request->input("worker_type_id");

        // Array de días feriados (formato: 'Y-m-d')
        $holidaysData = Holidays::for(country: 'pe')->get(year: now()->format('Y'));
        $holidays = array_map(function($holiday) {
            return \Carbon\Carbon::parse($holiday['date'])->format('Y-m-d');
        }, $holidaysData);

        $workers = Worker::query()
            ->with([
                'workerType',
                'sales' => function ($query) use ($dateStartConsumption, $dateEndConsumption, $typeDiscount, $categoryId, $holidays) {
                    $query
                        ->with(['saleDetails.product'])
                        ->where('serie', '001')
                        //->where('deal_in_form', 'SUBVENCION')
                        // Excluir domingos (DAYOFWEEK: 1=Domingo, 7=Sábado en MySQL)
                        ->whereRaw('DAYOFWEEK(sale_date) != 1')
                        // Excluir días feriados si hay alguno definido
                        ->when(!empty($holidays), function ($query) use ($holidays) {
                            $query->whereNotIn(DB::raw('DATE(sale_date)'), $holidays);
                        })
                        ->when(!empty($typeDiscount), function ($query) use ($typeDiscount) {
                            $query->where("deal_in_form", $typeDiscount);
                        })
                        ->when(!empty($dateStartConsumption), function ($query) use ($dateStartConsumption) {
                            $query->whereDate("sale_date", ">=", $dateStartConsumption);
                        })
                        ->when(!empty($dateEndConsumption), function ($query) use ($dateEndConsumption) {
                            $query->whereDate("sale_date", "<=", $dateEndConsumption);
                        })
                        ->when(!empty($categoryId), function ($query) use ($categoryId) {
                            $query->whereHas("saleDetails.product", function ($query) use ($categoryId) {
                                $query->where("category_id", $categoryId);
                            });
                        })
                        ->orderByDesc("sale_date")
                        ->orderByDesc("id");
                }
            ])
            ->when(!empty($typeFormId), function ($query) use ($typeFormId) {
                $query->where("type_form_id", $typeFormId);
            })
            ->when(!empty($areaId), function ($query) use ($areaId) {
                $query->where("area_id", $areaId);
            })
            ->when(!empty($workerTypeId), function ($query) use ($workerTypeId) {
                $query->where("worker_type_id", $workerTypeId);
            })
            ->when(!empty($search), function ($query) use ($search) {
                $query->where(function ($query) use ($search){
                    $query
                        ->where("names", "LIKE", "%{$search}%")
                        ->orWhere("surnames", "LIKE", "%{$search}%")
                        ->orWhere("numdoc", "LIKE", "%{$search}%");
                });
            })
            ->orderBy("surnames","ASC")
            ->orderBy("names","ASC");

        return $workers;
    }

    public function queryListSubvencionPerDaySpecial(Request $request)
    {
        $search = trim($request->input("search"));
        $dateStartConsumption = $request->input("dateStartConsumption");
        $dateEndConsumption = $request->input("dateEndConsumption");
        $categoryId = $request->input("categoryId");
        $typeFormId = $request->input("typeFormId");
        $areaId = $request->input("areaId");
        $typeDiscount = $request->input("typeDiscount");
        $workerTypeId = $request->input("worker_type_id");

        // Array de días feriados (formato: 'Y-m-d')
        $holidaysData = Holidays::for(country: 'pe')->get(year: now()->format('Y'));
        $holidays = array_map(function($holiday) {
            return \Carbon\Carbon::parse($holiday['date'])->format('Y-m-d');
        }, $holidaysData);

        $workers = Worker::query()
            ->with([
                'workerType',
                'sales' => function ($query) use ($dateStartConsumption, $dateEndConsumption, $typeDiscount, $categoryId, $holidays) {
                    $query
                        ->with(['saleDetails.product'])
                        ->where('serie', '001')
                        //->where('deal_in_form', 'SUBVENCION')
                        // Incluir SOLO domingos O días feriados (DAYOFWEEK: 1=Domingo en MySQL)
                        ->where(function ($query) use ($holidays) {
                            $query->whereRaw('DAYOFWEEK(sale_date) = 1'); // Domingos
                            if (!empty($holidays)) {
                                $query->orWhereIn(DB::raw('DATE(sale_date)'), $holidays); // Días feriados
                            }
                        })
                        ->when(!empty($typeDiscount), function ($query) use ($typeDiscount) {
                            $query->where("deal_in_form", $typeDiscount);
                        })
                        ->when(!empty($dateStartConsumption), function ($query) use ($dateStartConsumption) {
                            $query->whereDate("sale_date", ">=", $dateStartConsumption);
                        })
                        ->when(!empty($dateEndConsumption), function ($query) use ($dateEndConsumption) {
                            $query->whereDate("sale_date", "<=", $dateEndConsumption);
                        })
                        ->when(!empty($categoryId), function ($query) use ($categoryId) {
                            $query->whereHas("saleDetails.product", function ($query) use ($categoryId) {
                                $query->where("category_id", $categoryId);
                            });
                        })
                        ->orderByDesc("sale_date")
                        ->orderByDesc("id");
                }
            ])
            ->when(!empty($typeFormId), function ($query) use ($typeFormId) {
                $query->where("type_form_id", $typeFormId);
            })
            ->when(!empty($areaId), function ($query) use ($areaId) {
                $query->where("area_id", $areaId);
            })
            ->when(!empty($workerTypeId), function ($query) use ($workerTypeId) {
                $query->where("worker_type_id", $workerTypeId);
            })
            ->when(!empty($search), function ($query) use ($search) {
                $query->where(function ($query) use ($search){
                    $query
                        ->where("names", "LIKE", "%{$search}%")
                        ->orWhere("surnames", "LIKE", "%{$search}%")
                        ->orWhere("numdoc", "LIKE", "%{$search}%");
                });
            })
            ->orderBy("surnames","ASC")
            ->orderBy("names","ASC");

        return $workers;
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
            //->where("deal_in_form","DESCUENTO_PLANILLA")
            ->join("sale_details","sales.id","=","sale_details.sale_id")
            ->join("workers","sales.worker_id","=","workers.id")
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
            ->join("workers","sales.worker_id","=","workers.id")
            ->join("products","sale_details.product_id","=","products.id")
            ->join("categories","products.category_id","=","categories.id")
            ->select("worker_id",DB::raw("

            SUM( CASE WHEN categories.name='DESAYUNO' THEN sale_details.quantity ELSE 0 END) AS total_desayunos,
            SUM( CASE WHEN categories.name='CENA' THEN sale_details.quantity ELSE 0 END) AS total_cenas,
            SUM( CASE WHEN categories.name='ALMUERZO' THEN sale_details.quantity ELSE 0 END) AS total_almuerzos,

            SUM( CASE WHEN products.internal_code='MENU A' THEN sale_details.quantity ELSE 0 END) AS total_menu_a,
            SUM( CASE WHEN products.internal_code='MENU B' THEN sale_details.quantity ELSE 0 END) AS total_menu_b,
            SUM( CASE WHEN products.internal_code='MENU C' THEN sale_details.quantity ELSE 0 END) AS total_menu_c,

            SUM( CASE WHEN categories.name='DESAYUNO' THEN sale_details.total ELSE 0 END) AS monto_desayunos,
            SUM( CASE WHEN categories.name='ALMUERZO' THEN sale_details.total ELSE 0 END) AS  monto_almuerzos,
            SUM( CASE WHEN categories.name='CENA' THEN sale_details.total ELSE 0 END) AS  monto_cenas,
            SUM( CASE WHEN categories.name != 'DESAYUNO' AND categories.name != 'ALMUERZO' AND categories.name != 'CENA' THEN sale_details.total ELSE 0 END) AS monto_snacks,

            SUM(CASE
                WHEN (workers.grant = 1 OR workers.grant_complete = 1) AND (products.internal_code='MENU A') THEN sales.total_pay_company
                ELSE 0
            END) AS total_subvencion_menu_a,
            SUM(CASE
                WHEN (workers.grant = 1 OR workers.grant_complete = 1) AND (products.internal_code='MENU A') THEN sales.total_dsct_form
                ELSE 0
            END) AS worker_price_menu_a,

            SUM(CASE
                WHEN (workers.grant = 1 OR workers.grant_complete = 1) AND (products.internal_code='MENU B') THEN sales.total_pay_company
                ELSE 0
            END) AS total_subvencion_menu_b,
            SUM(CASE
                WHEN (workers.grant = 1 OR workers.grant_complete = 1) AND (products.internal_code='MENU B') THEN sales.total_dsct_form
                ELSE 0
            END) AS worker_price_menu_b,

            SUM(CASE
                WHEN (workers.grant = 1 OR workers.grant_complete = 1) AND (products.internal_code='MENU C') THEN sales.total_pay_company
                ELSE 0
            END) AS total_subvencion_menu_c,
            SUM(CASE
                WHEN (workers.grant = 1 OR workers.grant_complete = 1) AND (products.internal_code='MENU C') THEN sales.total_dsct_form
                ELSE 0
            END) AS worker_price_menu_c,


             SUM(CASE
                WHEN (workers.grant = 1 OR workers.grant_complete = 1) AND (categories.name = 'ALMUERZO') THEN sales.total_pay_company
                ELSE 0
            END) AS total_subvencion,
            SUM(CASE
                WHEN (workers.grant = 1 OR workers.grant_complete = 1) AND (categories.name = 'ALMUERZO') THEN sales.total_dsct_form
                ELSE 0
            END) AS worker_price
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
            ->orderBy("workers.surnames","ASC")
            ->groupBy("worker_id");
            //->orderBy("id");

        return $sales;
    }
}
