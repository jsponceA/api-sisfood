<?php

namespace App\Exports;

use App\Http\Traits\ConsumptionTrait;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SubvencionPerDay implements FromView, ShouldAutoSize
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
}
