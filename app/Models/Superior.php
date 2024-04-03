<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Superior extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "names",
    ];
}