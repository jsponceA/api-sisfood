<?php

use App\Models\Area;
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
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string("name",255);
            $table->datetimes();
            $table->softDeletesDatetime();
        });

        /*Area::query()->create([
            "name" => "01.1 Corte Barnizado y Litografía "
        ]);
        Area::query()->create([
            "name" => "01.2 Tapas Convencionales"
        ]);
        Area::query()->create([
            "name" => "01.6 Embutidos"
        ]);*/
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
