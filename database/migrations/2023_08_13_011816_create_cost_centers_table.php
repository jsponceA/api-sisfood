<?php

use App\Models\CostCenter;
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
        Schema::create('cost_centers', function (Blueprint $table) {
            $table->id();
            $table->string("name",255);
            $table->datetimes();
            $table->softDeletesDatetime();
        });

        /*CostCenter::query()
            ->create([
            "name" => "TAPAS CONVENCIONALES"
        ]);
        CostCenter::query()
            ->create([
                "name" => "ALMACEN PROD TERMINADO PLANTA CENTRAL"
            ]);
        CostCenter::query()
            ->create([
                "name" => "BARNIZADO"
            ]);*/
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_centers');
    }
};
