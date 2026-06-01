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
        "template_data",
        "template_engine",
        "template_version",
        "template_hash",
        "template_created_at",
        "is_active",
    ];

    protected $casts = [
        "capture_metadata" => "array",
        "template_created_at" => "datetime",
        "is_active" => "boolean",
    ];

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
