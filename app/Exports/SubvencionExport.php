<?php

namespace App\Exports;

use App\Http\Traits\ConsumptionTrait;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SubvencionExport implements FromView, ShouldAutoSize, WithColumnFormatting
{
    use ConsumptionTrait;
    public $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function view(): View
    {
        $consumptions = $this->queryListSubvencion($this->params)->get();

        return view("reports.consumption.list_excel_subvencion")->with(compact("consumptions"));
    }

    public function columnFormats(): array
    {
        return [
            'I' => '"S/ "#,##0.00', // SUBVENCION
            'J' => '"S/ "#,##0.00', // TRABAJADOR
        ];
    }
}
