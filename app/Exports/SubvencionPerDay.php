<?php

namespace App\Exports;

use App\Http\Traits\ConsumptionTrait;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class SubvencionPerDay implements FromView, ShouldAutoSize, WithEvents
{
    use ConsumptionTrait;
    public $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function view(): View
    {
        $workers = $this->queryListSubvencionPerDay($this->params)->get();

        $dateStartConsumption = $this->params->dateStartConsumption;
        $dateEndConsumption = $this->params->dateEndConsumption;
        $periodo = CarbonPeriod::create($dateStartConsumption, $dateEndConsumption);

        // El calculo vive en ConsumptionTrait para que este reporte y el de
        // planilla mensual apliquen exactamente las mismas reglas.
        $planilla = [];
        foreach ($workers as $worker) {
            $planilla[$worker->id] = $this->calcularPlanillaPorDia($worker, $periodo);
        }

        return view("reports.consumption.list_excel_subvencion_per_day")->with(compact("workers","periodo","planilla"));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                $highestColumnIndex = Coordinate::columnIndexFromString($highestColumn);

                // Las últimas 13 columnas: 12 totales (3 conceptos x 4 cols: SUBV, DESC, FACTURA, PLANILLA) + 1 AUTORIZO
                $totalColumnsStart = $highestColumnIndex - 12;

                for ($row = 4; $row <= $highestRow; $row++) {
                    for ($col = $totalColumnsStart; $col < $highestColumnIndex; $col++) {
                        $positionInTotals = $col - $totalColumnsStart; // 0-11
                        $positionInGroup = $positionInTotals % 4;      // 0=SUBV, 1=DESC, 2=FACTURA, 3=PLANILLA

                        $cell = $sheet->getCellByColumnAndRow($col, $row);
                        $numberFormat = $cell->getStyle()->getNumberFormat();

                        if ($positionInGroup === 0 || $positionInGroup === 1) {
                            // TOT.SUBVENCION (0) y TOT.DESCUENTO (1): enteros, sin decimales
                            $numberFormat->setFormatCode(NumberFormat::FORMAT_NUMBER);
                        } else {
                            // FACTURA (2) y PLANILLA (3): 2 decimales
                            $numberFormat->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                        }
                    }
                }
            },
        ];
    }
}
