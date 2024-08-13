<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleDetail extends Model
{
    public $timestamps = false;
    protected $fillable = [
        "product_id",
        "product_name",
        "quantity",
        "sale_price",
        "total",
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class)->with(["worker"]);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->with(["category"])->withDefault();
    }
}
