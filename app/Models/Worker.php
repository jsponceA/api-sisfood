<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "type_form_id",
        "area_id",
        "cost_center_id",
        "campus_id",
        "names",
        "surnames",
        "typedoc",
        "numdoc",
        "gender",
        "phone",
        "email",
        "address",
        "birth_date",
        "admission_date",
        "suspension_date",
        "terminated_worker",
        "breakfast",
        "lunch",
        "dinner",
    ];

    protected $casts = [
        "breakfast" => "integer",
        "lunch" => "integer",
        "dinner" => "integer",
    ];

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function typeForm(): BelongsTo
    {
        return $this->belongsTo(TypeForm::class);
    }
}
