<?php

use App\Models\Role;
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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string("name",50);
            $table->datetimes();
            $table->softDeletesDatetime();
        });

        Role::query()->create([
            "name" => "ADMIN"
        ]);
        Role::query()->create([
            "name" => "RRHH"
        ]);
        Role::query()->create([
            "name" => "VENTAS"
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
