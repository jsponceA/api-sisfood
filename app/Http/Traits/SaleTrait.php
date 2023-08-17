<?php

namespace App\Http\Traits;

use App\Models\Sale;
use Illuminate\Support\Str;

trait SaleTrait
{
    public function generateSerie($serie)
    {
       return Str::padLeft($serie,3,"0");
    }
}
