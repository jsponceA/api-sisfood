<?php

namespace App\Http\Controllers;

use App\Imports\WorkerImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TestController extends Controller
{
    public function index()
    {
        return view("test");
    }
    public function importarExcelTrabajador(Request $request)
    {
        $archivo = $request->file("archivo");
        $importar = Excel::import(new WorkerImport(),$archivo);
        //dd($importar);
    }
}
