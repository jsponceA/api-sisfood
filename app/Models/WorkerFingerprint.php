<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkerFingerprint extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "worker_id",
        "finger_label",
        "sample_format",
        "sample_data",
        "image_data",
        "device_uid",
        "quality",
        "capture_metadata",
    ];

    protected $casts = [
        "capture_metadata" => "array",
    ];

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
