<?php

namespace App\Exports;


use App\Http\Traits\ConsumptionTrait;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class SubvencionPerDaySpecial implements FromView, ShouldAutoSize, WithEvents
{

    use ConsumptionTrait;
    public $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function view(): View
    {
        $workers = $this->queryListSubvencionPerDaySpecial($this->params)->get();
        $dateStartConsumption = $this->params->dateStartConsumption;
        $dateEndConsumption = $this->params->dateEndConsumption;

        // Crear período completo
        $periodoCompleto = CarbonPeriod::create($dateStartConsumption, $dateEndConsumption);

        // Obtener años del rango de fechas
        $startYear = \Carbon\Carbon::parse($dateStartConsumption)->year;
        $endYear = \Carbon\Carbon::parse($dateEndConsumption)->year;

        // Obtener días feriados de Perú para todos los años en el rango
        $holidays = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $yearHolidaysData = \Spatie\Holidays\Holidays::for(country: 'pe')->get(year: $year);
            $yearHolidaysDates = array_map(function($holiday) {
                return \Carbon\Carbon::parse($holiday['date'])->format('Y-m-d');
            }, $yearHolidaysData);
            $holidays = array_merge($holidays, $yearHolidaysDates);
        }

        // Filtrar solo domingos Y días feriados (ambos)
        $periodo = collect($periodoCompleto)->filter(function($date) use ($holidays) {
            $isDomingo = $date->dayOfWeek === 0; // 0 = Domingo en Carbon
            $isFeriado = in_array($date->format('Y-m-d'), $holidays);
            // Retornar true si es domingo O es feriado (incluye ambos casos)
            return $isDomingo || $isFeriado;
        });

        return view("reports.consumption.list_excel_subvencion_per_day_special")->with(compact("workers","periodo","dateStartConsumption","dateEndConsumption"));
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $dateStartConsumption = $this->params->dateStartConsumption;
                $dateEndConsumption = $this->params->dateEndConsumption;

                // Crear período completo
                $periodoCompleto = CarbonPeriod::create($dateStartConsumption, $dateEndConsumption);

                // Obtener años del rango de fechas
                $startYear = \Carbon\Carbon::parse($dateStartConsumption)->year;
                $endYear = \Carbon\Carbon::parse($dateEndConsumption)->year;

                // Obtener días feriados de Perú para todos los años en el rango
                $holidays = [];
                for ($year = $startYear; $year <= $endYear; $year++) {
                    $yearHolidaysData = \Spatie\Holidays\Holidays::for(country: 'pe')->get(year: $year);
                    $yearHolidaysDates = array_map(function($holiday) {
                        return \Carbon\Carbon::parse($holiday['date'])->format('Y-m-d');
                    }, $yearHolidaysData);
                    $holidays = array_merge($holidays, $yearHolidaysDates);
                }

                // Filtrar solo domingos Y días feriados (ambos)
                $periodo = collect($periodoCompleto)->filter(function($date) use ($holidays) {
                    $isDomingo = $date->dayOfWeek === 0; // 0 = Domingo en Carbon
                    $isFeriado = in_array($date->format('Y-m-d'), $holidays);
                    // Retornar true si es domingo O es feriado (incluye ambos casos)
                    return $isDomingo || $isFeriado;
                });

                // Calcular el número de días en el período (solo domingos y feriados)
                $numDays = $periodo->count();

                // Columnas fijas al inicio: N°, DNI, APELLIDOS Y NOMBRES, TIPO TRABAJADOR, AREA = 5 columnas
                // Columnas por día: ALMUERZO (SUB, DESC), CENA (SUB, DESC) = 4 columnas por día (sin LONCHE)
                $fixedColumns = 5;
                $columnsPerDay = 4;
                $dynamicColumns = $numDays * $columnsPerDay;

                // Calcular la posición de inicio de los totales
                $startTotalsColumn = $fixedColumns + $dynamicColumns + 1; // +1 porque las columnas empiezan en 1

                // TOT. ALMUERZO: TOT.SUBVENCION (col1), TOT.DESCUENTO (col2), FACTURA (col3), PLANILLA (col4)
                // TOT. CENA: TOT.SUBVENCION (col5), TOT.DESCUENTO (col6), FACTURA (col7), PLANILLA (col8)
                // TOT. SNACKS: (col9)

                $almuerzoFacturaCol = $startTotalsColumn + 2; // Columna FACTURA de ALMUERZO
                $almuerzoPlanillaCol = $startTotalsColumn + 3; // Columna PLANILLA de ALMUERZO
                $cenaFacturaCol = $startTotalsColumn + 6; // Columna FACTURA de CENA
                $cenaPlanillaCol = $startTotalsColumn + 7; // Columna PLANILLA de CENA
                $snacksCol = $startTotalsColumn + 8; // Columna TOT. SNACKS

                // Obtener la hoja activa
                $sheet = $event->sheet->getDelegate();

                // Convertir números de columna a letras
                $columnLetters = [
                    \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($almuerzoFacturaCol),
                    \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($almuerzoPlanillaCol),
                    \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($cenaFacturaCol),
                    \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($cenaPlanillaCol),
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
