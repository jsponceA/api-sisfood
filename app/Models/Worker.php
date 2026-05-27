<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Worker extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        "type_form_id",
        "area_id",
        "cost_center_id",
        "campus_id",
        "payroll_area_id",
        "staff_division_id",
        "organizational_unit_id",
        "superior_id",
        "business_id",
        "charge_id",
        "composition_id",
        "gender_id",
        "type_document_id",
        "worker_type_id",
        "managent_id",
        "personal_code",
        "names",
        "surnames",
        "email",
        "numdoc",
        "phone",
        "address",
        "birth_date",
        "admission_date",
        "suspension_date",
        "terminated_worker",
        "breakfast",
        "lunch",
        "dinner",
        "grant",
        "grant_complete",
        "allowed_meals",
        "condition",
        "cod_reg_lab",
        "photo"
    ];

    protected $appends = [
        "full_name",
        "photo_url"
    ];

    protected $casts = [
        "allowed_meals" => "array",
    ];

    protected function fullName(): Attribute
    {
        return Attribute::get(fn() => "{$this->surnames} {$this->names}");
    }

    protected function photoUrl(): Attribute
    {
        return Attribute::get(fn() => !empty($this->photo) ? Storage::url("workers/{$this->photo}") : null);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class)->withDefault();
    }

    public function typeForm(): BelongsTo
    {
        return $this->belongsTo(TypeForm::class)->withDefault();
    }

    public function costCenter(): BelongsTo
    {
        return $this->belongsTo(CostCenter::class)->withDefault();
    }

    public function payrollArea(): BelongsTo
    {
        return $this->belongsTo(PayrollArea::class)->withDefault();
    }

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class)->withDefault();
    }

    public function staffDivision(): BelongsTo
    {
        return $this->belongsTo(StaffDivision::class)->withDefault();
    }

    public function charge(): BelongsTo
    {
        return $this->belongsTo(Charge::class)->withDefault();
    }

    public function organizationalUnit(): BelongsTo
    {
        return $this->belongsTo(OrganizationalUnit::class)->withDefault();
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class)->withDefault();
    }

    public function superior(): BelongsTo
    {
        return $this->belongsTo(Superior::class)->withDefault();
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class)->withDefault();
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function fingerprints(): HasMany
    {
        return $this->hasMany(WorkerFingerprint::class)->orderByDesc("id");
    }

    public function faces(): HasMany
    {
        return $this->hasMany(WorkerFaceProfile::class)->orderByDesc("id");
    }
}
