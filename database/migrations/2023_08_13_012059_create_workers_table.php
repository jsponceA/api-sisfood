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
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("type_form_id")->nullable();
            $table->unsignedBigInteger("area_id")->nullable();
            $table->unsignedBigInteger("cost_center_id")->nullable();
            $table->unsignedBigInteger("campus_id")->nullable();
            $table->string("names",100);
            $table->string("surnames",100);
            $table->enum("typedoc",["DNI","CARNET_EXTRANJERIA","RUC"]);
            $table->string("numdoc",20);
            $table->enum("gender",["HOMBRE","MUJER"]);
            $table->string("phone",20)->nullable();
            $table->string("email",100)->nullable();
            $table->string("address",250)->nullable();
            $table->date("birth_date")->nullable();
            $table->date("admission_date")->nullable();
            $table->date("suspension_date")->nullable();
            $table->boolean("terminated_worker")->nullable();
            $table->boolean("breakfast")->nullable();
            $table->boolean("lunch")->nullable();
            $table->boolean("dinner")->nullable();
            $table->datetimes();
            $table->softDeletesDatetime();
            $table->foreign("type_form_id")->references("id")->on("type_forms");
            $table->foreign("area_id")->references("id")->on("areas");
            $table->foreign("cost_center_id")->references("id")->on("cost_centers");
            $table->foreign("campus_id")->references("id")->on("campuses");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workers');
    }
};
