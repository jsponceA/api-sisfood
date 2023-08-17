<?php

namespace App\Exports;


use App\Http\Controllers\WorkerController;
use App\Http\Traits\WorkerTrait;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WorkerExport implements FromView, ShouldAutoSize
{
    use WorkerTrait;
    public $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function view(): View
    {
        $workers = $this->queryList($this->params)->get();

        return view("reports.worker.list_excel")->with(compact("workers"));
    }
}
