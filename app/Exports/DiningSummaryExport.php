<?php

namespace App\Exports;

use App\Http\Traits\ConsumptionTrait;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

/**
 * Reporte "RESUMEN DE COMEDOR": dos cuadros agrupados por GERENCIA.
 *  - Cuadro azul  (Cuenta de REFRIGERIO): cantidad de consumos por comida.
 *  - Cuadro naranja (Suma de PRECIO_REFRIG): importe (S/) por comida.
 * Ambos con su fila de totales por columna. Información 100% dinámica.
 */
class DiningSummaryExport implements FromView, ShouldAutoSize
{
    use ConsumptionTrait;

    public $params;

    /** Columnas de comida del reporte: clave interna => etiqueta visible. */
    const BUCKETS = [
        "DESAYUNO" => "DESAYUNO",
        "ALMUERZO" => "ALMUERZO",
        "LONCHE" => "LONCHE",
        "CENA" => "CENA",
    ];

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function view(): View
    {
        $details = $this->queryList($this->params)->get();

        $bucketKeys = array_keys(self::BUCKETS);

        // [gerencia => ['cant' => [bucket => n], 'imp' => [bucket => monto]]]
        $rows = [];
        $totalCant = array_fill_keys($bucketKeys, 0);
        $totalImp = array_fill_keys($bucketKeys, 0);

        foreach ($details as $detail) {
            $bucket = $this->resolveBucket($detail->product?->category?->name);
            if ($bucket === null) {
                continue; // categoría fuera del comedor (snacks, bebidas, etc.)
            }

            $gerencia = trim((string) ($detail->sale?->worker?->managent?->name ?? ""));
            if ($gerencia === "") {
                $gerencia = "SIN GERENCIA";
            }

            if (!isset($rows[$gerencia])) {
                $rows[$gerencia] = [
                    "cant" => array_fill_keys($bucketKeys, 0),
                    "imp" => array_fill_keys($bucketKeys, 0),
                ];
            }

            $qty = (float) ($detail->quantity ?? 0);
            if ($qty <= 0) {
                $qty = 1;
            }
            // SALE_PRICE del producto que corresponde a la comida (dinámico desde la BD)
            $price = (float) ($detail->product?->sale_price ?? $detail->sale_price ?? 0);
            $amount = $price * $qty;

            $rows[$gerencia]["cant"][$bucket] += $qty;
            $rows[$gerencia]["imp"][$bucket] += $amount;
            $totalCant[$bucket] += $qty;
            $totalImp[$bucket] += $amount;
        }

        ksort($rows); // orden alfabético por gerencia

        return view("reports.consumption.list_excel_dining_summary")->with([
            "buckets" => self::BUCKETS,
            "rows" => $rows,
            "totalCant" => $totalCant,
            "totalImp" => $totalImp,
            "title" => $this->buildTitle(),
        ]);
    }

    /** Título del reporte concatenado con el rango de fechas empleado. */
    private function buildTitle(): string
    {
        $base = "RESUMEN DE CONSUMO DE COMEDOR";

        $start = $this->params->dateStartConsumption ?? null;
        $end = $this->params->dateEndConsumption ?? null;

        if (empty($start) && empty($end)) {
            return $base;
        }

        $start = !empty($start) ? Carbon::parse($start) : Carbon::parse($end);
        $end = !empty($end) ? Carbon::parse($end) : Carbon::parse($start);

        return "{$base} DEL {$start->format("d/m/Y")} AL {$end->format("d/m/Y")}";
    }

    /** Normaliza el nombre de categoría a una de las columnas del reporte. */
    private function resolveBucket(?string $categoryName): ?string
    {
        $name = strtoupper(trim((string) $categoryName));
        if ($name === "ALMUERZO") {
            return "ALMUERZO";
        }
        if ($name === "CENA") {
            return "CENA";
        }
        if ($name === "DESAYUNO") {
            return "DESAYUNO";
        }
        if (in_array($name, ["LONCHE", "LONCHES", "LOCHE", "LOCHES"], true)) {
            return "LONCHE";
        }

        return null;
    }
}
