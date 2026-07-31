<?php

namespace App\Http\Traits;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait ConsumptionTrait
{
    public function queryList(Request $request)
    {
        $search = trim($request->input("search") ?? "");
        $dateStartConsumption = $request->input("dateStartConsumption");
        $dateEndConsumption = $request->input("dateEndConsumption");
        $categoryId = $request->input("categoryId");
        $typeFormId = $request->input("typeFormId");
        $areaId = $request->input("areaId");
        $workerTypeId = $request->input("workerTypeId");
        $costCenterId = $request->input("costCenterId");
        $typeDiscount = $request->input("typeDiscount");


        $sales = SaleDetail::query()
            ->with(["sale", "product"])
            ->whereHas("sale.worker", function ($query) use ($search, $typeFormId, $areaId, $workerTypeId, $costCenterId) {
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
                    ->when(!empty($costCenterId), function ($query) use ($costCenterId) {
                        $query
                            ->where("cost_center_id", $costCenterId);
                    })
                    ->when(!empty($search), function ($query) use ($search) {
                        $query
                            ->where(function ($query) use ($search){
                                $query
                                    ->where("names", "LIKE", "%{$search}%")
                                    ->orWhere("surnames", "LIKE", "%{$search}%")
                                    ->orWhere("numdoc", "LIKE", "%{$search}%")
                                    ->orWhere("personal_code", "LIKE", "%{$search}%");
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
        $search = trim($request->input("search") ?? "");
        $dateStartConsumption = $request->input("dateStartConsumption");
        $dateEndConsumption = $request->input("dateEndConsumption");
        $categoryId = $request->input("categoryId");
        $typeFormId = $request->input("typeFormId");
        $areaId = $request->input("areaId");
        $workerTypeId = $request->input("workerTypeId");
        $costCenterId = $request->input("costCenterId");
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
            ->whereHas("worker", function ($query) use ($search, $typeFormId, $areaId, $workerTypeId, $costCenterId) {
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
                    ->when(!empty($costCenterId), function ($query) use ($costCenterId) {
                        $query
                            ->where("cost_center_id", $costCenterId);
                    })
                    ->when(!empty($search), function ($query) use ($search) {
                        $query
                            ->where(function ($query) use ($search){
                                $query
                                    ->where("names", "LIKE", "%{$search}%")
                                    ->orWhere("surnames", "LIKE", "%{$search}%")
                                    ->orWhere("numdoc", "LIKE", "%{$search}%")
                                    ->orWhere("personal_code", "LIKE", "%{$search}%");
                            });
                    });
            })
            ->whereHas("saleDetails.product", function ($query) use ($categoryId) {
                $query->when(!empty($categoryId), function ($query) use ($categoryId) {
                    $query->where("category_id", $categoryId);
                });
            })
            ->orderByDesc("sale_date")
            ->orderByDesc("id");

        return $sales;
    }

    public function queryListSubvencionPerDay(Request $request)
    {
        $search = trim($request->input("search") ?? "");
        $dateStartConsumption = $request->input("dateStartConsumption");
        $dateEndConsumption = $request->input("dateEndConsumption");
        $categoryId = $request->input("categoryId");
        $typeFormId = $request->input("typeFormId");
        $areaId = $request->input("areaId");
        $workerTypeId = $request->input("workerTypeId");
        $costCenterId = $request->input("costCenterId");
        $typeDiscount = $request->input("typeDiscount");

        // Filtros de las ventas del rango solicitado. Se reutiliza para cargar las
        // ventas y para descartar del reporte a los trabajadores sin consumos.
        $filtroVentas = function ($query) use ($dateStartConsumption, $dateEndConsumption, $typeDiscount, $categoryId) {
            $query
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
                });
        };

        $workers = Worker::query()
            ->with([
                'area',
                'costCenter',
                'workerType',
                'sales' => function ($query) use ($filtroVentas) {
                    $filtroVentas($query);

                    $query
                        ->with(['saleDetails.product.category'])
                        ->orderByDesc("sale_date")
                        ->orderByDesc("id");
                }
            ])
            ->whereHas("sales", $filtroVentas)
            ->when(!empty($typeFormId), function ($query) use ($typeFormId) {
                $query->where("type_form_id", $typeFormId);
            })
            ->when(!empty($areaId), function ($query) use ($areaId) {
                $query->where("area_id", $areaId);
            })
            ->when(!empty($workerTypeId), function ($query) use ($workerTypeId) {
                $query->where("worker_type_id", $workerTypeId);
            })
            ->when(!empty($costCenterId), function ($query) use ($costCenterId) {
                $query->where("cost_center_id", $costCenterId);
            })
            ->when(!empty($search), function ($query) use ($search) {
                $query->where(function ($query) use ($search){
                    $query
                        ->where("names", "LIKE", "%{$search}%")
                        ->orWhere("surnames", "LIKE", "%{$search}%")
                        ->orWhere("numdoc", "LIKE", "%{$search}%")
                        ->orWhere("personal_code", "LIKE", "%{$search}%");
                });
            })
            ->orderBy("surnames","ASC")
            ->orderBy("names","ASC");

        return $workers;
    }

    /**
     * Calcula, para un trabajador, la subvencion de la empresa y el descuento a
     * planilla de cada dia del periodo, ademas de los acumulados por tipo de comida.
     *
     * Concentra las reglas de negocio de los reportes de planilla para que todos
     * apliquen exactamente el mismo criterio:
     *  - Solo se descuenta a planilla si la venta registro descuento
     *    (total_dsct_form > 0). En pagos en efectivo o subvencion completa va cero.
     *  - Los sabados el almuerzo se factura completo a la empresa, sin descuento
     *    al trabajador, pero los adicionales/EXTRAS si se descuentan.
     *  - Cualquier categoria que no sea DESAYUNO, LONCHE, ALMUERZO o CENA se
     *    considera adicional y se suma al descuento del almuerzo.
     *
     * @param  \App\Models\Worker  $worker  con la relacion "sales.saleDetails.product.category" cargada
     * @param  iterable  $periodo  dias del rango (CarbonPeriod)
     */
    public function calcularPlanillaPorDia($worker, $periodo): array
    {
        $totales = [
            "cantidadDesayunoSubvencion" => 0,
            "cantidadDesayunoDescuento" => 0,
            "totalSubvencionDesayuno" => 0,
            "totalDescuentoDesayuno" => 0,
            "cantidadAlmuerzoSubvencion" => 0,
            "cantidadAlmuerzoDescuento" => 0,
            "totalSubvencionAlmuerzo" => 0,
            "totalDescuentoAlmuerzo" => 0,
            "cantidadCenaSubvencion" => 0,
            "cantidadCenaDescuento" => 0,
            "totalSubvencionCena" => 0,
            "totalDescuentoCena" => 0,
            "descuentoGeneral" => 0,
        ];

        $dias = [];

        foreach ($periodo as $p) {
            // Los sabados el almuerzo se factura completo a la empresa (subvencion),
            // sin descuento a planilla.
            $esSabado = $p->isSaturday();

            $desayunoSubvencion = 0;
            $desayunoDescuento = 0;
            $almuerzoSubvencion = 0;
            $almuerzoDescuento = 0;
            $cenaSubvencion = 0;
            $cenaDescuento = 0;
            $almuerzoDescuentoBaseDia = 0;
            $almuerzoExtrasDia = 0;
            $tieneAlmuerzoDia = false;

            foreach ($worker->sales as $sale) {
                if (empty($sale->sale_date)) {
                    continue;
                }
                if (!\Carbon\Carbon::parse($sale->sale_date)->isSameDay($p)) {
                    continue;
                }

                $hasDesayuno = false;
                $hasAlmuerzo = false;
                $hasCena = false;
                $montoAlmuerzoVenta = 0; // total del/los almuerzo(s) de esta venta

                // Precios dinamicos del producto: subvencion = company_price, descuento = worker_price
                $desayunoCompanyPrice = 0;
                $desayunoWorkerPrice = 0;
                $almuerzoCompanyPrice = 0;
                $almuerzoWorkerPrice = 0;
                $almuerzoSalePrice = 0;
                $cenaCompanyPrice = 0;
                $cenaWorkerPrice = 0;

                foreach ($sale->saleDetails as $detail) {
                    $categoryName = $detail->product?->category?->name;
                    $detailAmount = $detail->total ?? 0;

                    if ($detailAmount <= 0) {
                        $detailQuantity = max($detail->quantity ?? 1, 1);
                        $detailAmount = ($detail->sale_price ?? 0) * $detailQuantity;
                    }

                    if ($categoryName == "DESAYUNO") {
                        $hasDesayuno = true;
                        $desayunoCompanyPrice = $detail->product?->company_price ?? 0;
                        $desayunoWorkerPrice = $detail->product?->worker_price ?? 0;
                    } elseif ($categoryName == "ALMUERZO") {
                        $hasAlmuerzo = true;
                        $tieneAlmuerzoDia = true;
                        $almuerzoCompanyPrice = $detail->product?->company_price ?? 0;
                        $almuerzoWorkerPrice = $detail->product?->worker_price ?? 0;
                        $almuerzoSalePrice = $detail->product?->sale_price ?? 0;

                        // Costo del menu completo = precio de venta del producto
                        $cantidadAlmuerzo = $detail->quantity ?? 1;
                        $precioMenuAlmuerzo = $detail->product?->sale_price ?? 0;
                        if ($precioMenuAlmuerzo <= 0) {
                            // Respaldo: total del detalle o precio del detalle x cantidad
                            $precioMenuAlmuerzo = ($detail->total ?? 0) > 0
                                ? ($detail->total / max($cantidadAlmuerzo, 1))
                                : ($detail->sale_price ?? 0);
                        }
                        $montoAlmuerzoVenta += $precioMenuAlmuerzo * $cantidadAlmuerzo;

                        // Solo se descuenta por planilla si la venta realmente lo registro.
                        if (($sale->total_dsct_form ?? 0) > 0) {
                            $almuerzoDescuentoBaseDia += $almuerzoWorkerPrice;
                        }
                    } elseif ($categoryName == "CENA") {
                        $hasCena = true;
                        $cenaCompanyPrice = $detail->product?->company_price ?? 0;
                        $cenaWorkerPrice = $detail->product?->worker_price ?? 0;
                    } elseif (!empty($categoryName) && !in_array($categoryName, ["DESAYUNO", "LONCHE", "ALMUERZO", "CENA"])) {
                        // Adicionales del trabajador (EXTRAS, SNACKS, BEBIDAS, GASEOSAS, TORTAS...)
                        $almuerzoExtrasDia += $detailAmount;
                    }
                }

                if ($hasDesayuno) {
                    if ($sale->deal_in_form == "SUBVENCION") {
                        $desayunoSubvencion = $desayunoCompanyPrice;
                        $totales["cantidadDesayunoSubvencion"]++;
                        $totales["totalSubvencionDesayuno"] += $sale->total_pay_company ?? 0;
                    }
                    if ($sale->deal_in_form == "SUBVENCION" && $sale->total_dsct_form > 0) {
                        $desayunoDescuento = $desayunoWorkerPrice;
                        $totales["cantidadDesayunoDescuento"]++;
                        $totales["totalDescuentoDesayuno"] += $sale->total_dsct_form ?? 0;
                    }
                }

                if ($hasAlmuerzo) {
                    if ($esSabado) {
                        $almuerzoSubvencion = $almuerzoSalePrice;
                        $almuerzoDescuento = 0;
                        $totales["cantidadAlmuerzoSubvencion"]++;
                        $totales["totalSubvencionAlmuerzo"] += $montoAlmuerzoVenta;
                    } else {
                        if ($sale->deal_in_form == "SUBVENCION") {
                            $almuerzoSubvencion = $almuerzoCompanyPrice;
                            $totales["cantidadAlmuerzoSubvencion"]++;
                            $totales["totalSubvencionAlmuerzo"] += $sale->total_pay_company ?? 0;
                        }
                    }
                }

                if ($hasCena) {
                    if ($sale->deal_in_form == "SUBVENCION") {
                        $cenaSubvencion = $cenaCompanyPrice;
                        $totales["cantidadCenaSubvencion"]++;
                        $totales["totalSubvencionCena"] += $sale->total_pay_company ?? 0;
                    }
                    if ($sale->deal_in_form == "SUBVENCION" && $sale->total_dsct_form > 0) {
                        $cenaDescuento = $cenaWorkerPrice;
                        $totales["cantidadCenaDescuento"]++;
                        $totales["totalDescuentoCena"] += $sale->total_dsct_form ?? 0;
                    }
                }
            }

            // Descuento a planilla del almuerzo del dia: menu + adicionales.
            if (!$esSabado && $tieneAlmuerzoDia) {
                $almuerzoDescuento = $almuerzoDescuentoBaseDia + $almuerzoExtrasDia;
                // Si se pago en efectivo y no hubo adicionales no hay nada que descontar.
                if ($almuerzoDescuento > 0) {
                    $totales["cantidadAlmuerzoDescuento"]++;
                    $totales["totalDescuentoAlmuerzo"] += $almuerzoDescuento;
                }
            } elseif ($almuerzoExtrasDia > 0) {
                $almuerzoDescuento = $almuerzoExtrasDia;
                $totales["totalDescuentoAlmuerzo"] += $almuerzoDescuento;
            }

            $descuentoDia = $desayunoDescuento + $almuerzoDescuento + $cenaDescuento;
            $totales["descuentoGeneral"] += $descuentoDia;

            $dias[$p->format("Y-m-d")] = [
                "desayunoSubvencion" => $desayunoSubvencion,
                "desayunoDescuento" => $desayunoDescuento,
                "almuerzoSubvencion" => $almuerzoSubvencion,
                "almuerzoDescuento" => $almuerzoDescuento,
                "cenaSubvencion" => $cenaSubvencion,
                "cenaDescuento" => $cenaDescuento,
                "descuentoDia" => $descuentoDia,
            ];
        }

        return ["dias" => $dias, "totales" => $totales];
    }


    public function queryListConsumption(Request $request)
    {
        $search = trim($request->input("search") ?? "");
        $dateStartConsumption = $request->input("dateStartConsumption");
        $dateEndConsumption = $request->input("dateEndConsumption");
        $categoryId = $request->input("categoryId");
        $typeFormId = $request->input("typeFormId");
        $areaId = $request->input("areaId");
        $workerTypeId = $request->input("workerTypeId");
        $costCenterId = $request->input("costCenterId");
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
            ->whereHas("worker", function ($query) use ($search, $typeFormId, $areaId, $workerTypeId, $costCenterId) {
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
                    ->when(!empty($costCenterId), function ($query) use ($costCenterId) {
                        $query
                            ->where("cost_center_id", $costCenterId);
                    })
                    ->when(!empty($search), function ($query) use ($search) {
                        $query
                            ->where(function ($query) use ($search){
                                $query
                                    ->where("names", "LIKE", "%{$search}%")
                                    ->orWhere("surnames", "LIKE", "%{$search}%")
                                    ->orWhere("numdoc", "LIKE", "%{$search}%")
                                    ->orWhere("personal_code", "LIKE", "%{$search}%");
                            });
                    });
            })
            ->whereHas("saleDetails.product", function ($query) use ($categoryId) {
                $query->when(!empty($categoryId), function ($query) use ($categoryId) {
                    $query->where("category_id", $categoryId);
                });
            })
            ->orderByDesc("id");

        return $sales;
    }

    public function queryListWorkerSummany(Request $request)
    {
        $search = trim($request->input("search") ?? "");
        $dateStartConsumption = $request->input("dateStartConsumption");
        $dateEndConsumption = $request->input("dateEndConsumption");
        $categoryId = $request->input("categoryId");
        $typeFormId = $request->input("typeFormId");
        $areaId = $request->input("areaId");
        $workerTypeId = $request->input("workerTypeId");
        $costCenterId = $request->input("costCenterId");
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
            ->whereHas("worker", function ($query) use ($search, $typeFormId, $areaId, $workerTypeId, $costCenterId) {
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
                    ->when(!empty($costCenterId), function ($query) use ($costCenterId) {
                        $query
                            ->where("cost_center_id", $costCenterId);
                    })
                    ->when(!empty($search), function ($query) use ($search) {
                        $query
                            ->where(function ($query) use ($search){
                                $query
                                    ->where("names", "LIKE", "%{$search}%")
                                    ->orWhere("surnames", "LIKE", "%{$search}%")
                                    ->orWhere("numdoc", "LIKE", "%{$search}%")
                                    ->orWhere("personal_code", "LIKE", "%{$search}%");
                            });
                    });
            })
            ->whereHas("saleDetails.product", function ($query) use ($categoryId) {
                $query->when(!empty($categoryId), function ($query) use ($categoryId) {
                    $query->where("category_id", $categoryId);
                });
            })
            ->orderBy("workers.surnames","ASC")
            ->groupBy("worker_id");
            //->orderBy("id");

        return $sales;
    }
}
