<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('staff_divisions', function (Blueprint $table) {
            $table->id();
            $table->string("name",100);
            $table->datetimes();
            $table->softDeletesDatetime();
        });

        \App\Models\StaffDivision::query()->create([
            "name" => "Lima - Amauta Impresiones C."
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_divisions');
    }
};
