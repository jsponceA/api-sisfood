<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        "name",
        "category",
        "barcode",
        "purchase_price",
        "sale_price",
        "worker_price",
        "igv_price",
        "company_price",
        "handle_stock",
        "current_stock",
        "expiration_date",
    ];
}
