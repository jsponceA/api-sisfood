<?php

use App\Models\TypeForm;
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
        Schema::create('type_forms', function (Blueprint $table) {
            $table->id();
            $table->string("name",100);
            $table->datetimes();
            $table->softDeletesDatetime();
        });

        TypeForm::query()
            ->create([
                "name" => "EMPLEADO"
            ]);

        TypeForm::query()
            ->create([
                "name" => "OBRERO"
            ]);

        TypeForm::query()
            ->create([
                "name" => "PRACTICANTE"
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_forms');
    }
};
