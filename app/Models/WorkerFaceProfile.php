<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class WorkerFaceProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'worker_id',
        'face_label',
        'image_path',
        'capture_metadata',
    ];

    protected $casts = [
        'capture_metadata' => 'array',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return !empty($this->image_path) ? Storage::url($this->image_path) : null;
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
