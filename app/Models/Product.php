<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        "name",
        "internal_code",
        "category_id",
        "barcode",
        "purchase_price",
        "sale_price",
        "worker_price",
        "igv_price",
        "company_price",
        "handle_stock",
        "current_stock",
        "expiration_date",
        "image"
    ];

    protected $appends = [
        "image_url"
    ];

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn($value, array $attributes) => !empty($attributes["image"]) ? Storage::url("products/{$attributes["image"]}") : null,
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,"category_id","id");
    }
}
