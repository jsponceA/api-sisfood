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
        Schema::create('genders', function (Blueprint $table) {
            $table->id();
            $table->string("name",100);
            $table->datetimes();
            $table->softDeletesDatetime();
        });

        $values = ["Masculino","Femenino"];

        foreach ($values as $item) {
            \App\Models\Gender::query()->create(["name"=>$item]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genders');
    }
};