<?php

namespace App\Exports;

use App\Http\Traits\ConsumptionTrait;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SubvencionExport implements FromView, ShouldAutoSize
{
    use ConsumptionTrait;
    public $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function view(): View
    {
        $consumptions = $this->queryList($this->params)->get();

        return view("reports.consumption.list_excel_subvencion")->with(compact("consumptions"));
    }
}
