<?php

namespace App\Http\Controllers;

use App\Imports\WorkerImport;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
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

    public function setearTodosDesayunos()
    {
        $ventas = Sale::query()
            ->whereHas("saleDetails",function ($q){
                $q->where("product_name","DESAYUNO");
            })
            ->get();

        foreach ($ventas as $venta) {
            $s = Sale::query()->findOrFail($venta->id);
            $s->total_sale = 4.20;
            $s->total_igv = 4.20;
            $s->total_dsct_form = 4.20;
            $s->total_pay_company = 0;
            $s->update();
        }
    }

    public function setearCategoriasProductos()
    {
        $productos = Product::query()
            ->whereNull("category_id")
            ->get();

        foreach ($productos as $pro) {
            $producto = Product::query()->findOrFail($pro->id);
            $producto->category_id = 5;
            $producto->update();
        }
    }
}
