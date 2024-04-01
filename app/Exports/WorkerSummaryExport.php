<?php

namespace App\Exports;

use App\Http\Traits\ConsumptionTrait;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WorkerSummaryExport implements FromView, ShouldAutoSize
{
    use ConsumptionTrait;
    public $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function view(): View
    {
        $sales = $this->queryListWorkerSummany($this->params)->get();
        $params = $this->params;

        return view("reports.consumption.list_excel_summary")->with(compact("sales","params"));
    }
}
