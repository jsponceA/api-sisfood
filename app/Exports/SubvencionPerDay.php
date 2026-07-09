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

        return view("reports.consumption.list_excel_subvencion_per_day")->with(compact("workers","periodo"));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $highestColumnIndex = Coordinate::columnIndexFromString($sheet->getHighestColumn());

                // Estructura: 5 columnas de datos del trabajador + (4 x días) + 4 CANTIDAD TOTAL + 4 IMPORTE TOTAL.
                $firstDayCol   = 6;                        // F: primera columna de comida por día (monto)
                $dayColEnd     = $highestColumnIndex - 8;  // última columna de días
                $cantidadStart = $highestColumnIndex - 7;  // primera columna CANTIDAD TOTAL
                $cantidadEnd   = $highestColumnIndex - 4;  // última columna CANTIDAD TOTAL
                $importeStart  = $highestColumnIndex - 3;  // primera columna IMPORTE TOTAL
                $importeEnd    = $highestColumnIndex;      // última columna IMPORTE TOTAL

                for ($row = 3; $row <= $highestRow; $row++) {
                    // Montos por día (comidas) e IMPORTE TOTAL: 2 decimales
                    for ($col = $firstDayCol; $col <= $dayColEnd; $col++) {
                        $sheet->getCellByColumnAndRow($col, $row)->getStyle()
                            ->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                    }
                    for ($col = $importeStart; $col <= $importeEnd; $col++) {
                        $sheet->getCellByColumnAndRow($col, $row)->getStyle()
                            ->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
                    }
                    // CANTIDAD TOTAL: enteros, sin decimales
                    for ($col = $cantidadStart; $col <= $cantidadEnd; $col++) {
                        $sheet->getCellByColumnAndRow($col, $row)->getStyle()
                            ->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER);
                    }
                }
            },
        ];
    }
}
