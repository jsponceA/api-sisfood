<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $fillable = [
        "name",
        "start_date",
        "end_date"
    ];
}
