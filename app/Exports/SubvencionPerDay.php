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

        return view("reports.consumption.list_excel_subvencion_per_day")->with(compact("workers","periodo","dateStartConsumption","dateEndConsumption"));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $dateStartConsumption = $this->params->dateStartConsumption;
                $dateEndConsumption = $this->params->dateEndConsumption;
                $periodo = CarbonPeriod::create($dateStartConsumption, $dateEndConsumption);

                // Calcular el número de días en el período
                $numDays = $periodo->count();

                // Columnas fijas al inicio: N°, DNI, APELLIDOS Y NOMBRES, TIPO TRABAJADOR, AREA = 5 columnas
                // Columnas por día: ALMUERZO (SUB, DESC), CENA (SUB, DESC), LONCHE (SUB, DESC) = 6 columnas por día
                $fixedColumns = 5;
                $columnsPerDay = 6;
                $dynamicColumns = $numDays * $columnsPerDay;

                // Calcular la posición de inicio de los totales
                $startTotalsColumn = $fixedColumns + $dynamicColumns + 1; // +1 porque las columnas empiezan en 1

                // TOT. ALMUERZO: TOT.SUBVENCION (col1), TOT.DESCUENTO (col2), FACTURA (col3), PLANILLA (col4)
                // TOT. CENA: TOT.SUBVENCION (col5), TOT.DESCUENTO (col6), FACTURA (col7), PLANILLA (col8)
                // TOT. LONCHE: TOT.SUBVENCION (col9), TOT.DESCUENTO (col10), FACTURA (col11), PLANILLA (col12)
                // TOT. SNACKS: (col13)

                $almuerzoFacturaCol = $startTotalsColumn + 2; // Columna FACTURA de ALMUERZO
                $almuerzoPlanillaCol = $startTotalsColumn + 3; // Columna PLANILLA de ALMUERZO
                $cenaFacturaCol = $startTotalsColumn + 6; // Columna FACTURA de CENA
                $cenaPlanillaCol = $startTotalsColumn + 7; // Columna PLANILLA de CENA
                $loncheFacturaCol = $startTotalsColumn + 10; // Columna FACTURA de LONCHE
                $lonchePlanillaCol = $startTotalsColumn + 11; // Columna PLANILLA de LONCHE
                $snacksCol = $startTotalsColumn + 12; // Columna TOT. SNACKS

                // Obtener la hoja activa
                $sheet = $event->sheet->getDelegate();

                // Convertir números de columna a letras
                $columnLetters = [
                    \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($almuerzoFacturaCol),
                    \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($almuerzoPlanillaCol),
                    \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($cenaFacturaCol),
                    \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($cenaPlanillaCol),
                    \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($loncheFacturaCol),
                    \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($lonchePlanillaCol),
                    \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($snacksCol),
                ];

                // Aplicar formato de moneda a las columnas FACTURA, PLANILLA y TOT. SNACKS
                foreach ($columnLetters as $column) {
                    $sheet->getStyle($column . '5:' . $column . '1000')
                        ->getNumberFormat()
                        ->setFormatCode('"S/ "#,##0.00');
                }
            },
        ];
    }
}
