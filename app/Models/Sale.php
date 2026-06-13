<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        "worker_id",
        "sale_date",
        "serie",
        "num_document",
        "total_sale",
        "total_igv",
        "total_dsct_form",
        "total_pay_company",
        "deal_in_form",
        "pay_type",
        "is_cash_payment_form",
        "created_at",
        "updated_at"
    ];

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class)->with(["area", "costCenter", "workerType", "payrollArea", "typeForm"])->withDefault();
    }
    public function saleDetails(): HasMany
    {
        return $this->hasMany(SaleDetail::class)->with(["product"]);
    }
}
