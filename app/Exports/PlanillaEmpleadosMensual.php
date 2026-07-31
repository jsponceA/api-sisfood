<?php

namespace App\Exports;

use App\Http\Traits\ConsumptionTrait;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

/**
 * Planilla de empleados mensual: una columna por dia del rango con el descuento
 * acumulado del trabajador (menu + adicionales) y un subtotal por trabajador.
 *
 * Reutiliza la misma consulta y el mismo calculo que el reporte de planilla
 * (SubvencionPerDay), solo que resumido en una sola columna por dia.
 */
class PlanillaEmpleadosMensual implements FromView, ShouldAutoSize, WithEvents
{
    use ConsumptionTrait;

    /** Columnas fijas antes de las fechas: N°, DNI, CODIGO, NOMBRES, TIPO, CENTRO DE COSTO */
    private const COLUMNAS_FIJAS = 6;

    public $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function view(): View
    {
        $workers = $this->queryListSubvencionPerDay($this->params)->get();

        $periodo = CarbonPeriod::create(
            $this->params->dateStartConsumption,
            $this->params->dateEndConsumption
        );

        $planilla = [];
        $totalesPorDia = [];
        $totalGeneral = 0;

        foreach ($periodo as $p) {
            $totalesPorDia[$p->format("Y-m-d")] = 0;
        }

        foreach ($workers as $worker) {
            $datos = $this->calcularPlanillaPorDia($worker, $periodo);
            $planilla[$worker->id] = $datos;

            foreach ($datos["dias"] as $fecha => $dia) {
                $totalesPorDia[$fecha] += $dia["descuentoDia"];
            }
            $totalGeneral += $datos["totales"]["descuentoGeneral"];
        }

        return view("reports.consumption.list_excel_planilla_mensual")
            ->with(compact("workers", "periodo", "planilla", "totalesPorDia", "totalGeneral"));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumnIndex = Coordinate::columnIndexFromString($sheet->getHighestColumn());

                // Importes con 2 decimales: desde la primera fecha hasta el SUBTOTAL.
                for ($row = 3; $row <= $highestRow; $row++) {
                    for ($col = self::COLUMNAS_FIJAS + 1; $col <= $highestColumnIndex; $col++) {
                        $sheet->getCellByColumnAndRow($col, $row)
                            ->getStyle()
                            ->getNumberFormat()
                            ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                    }
                }
            },
        ];
    }
}
