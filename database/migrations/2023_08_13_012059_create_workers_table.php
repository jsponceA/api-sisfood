<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->unsignedBigInteger("payroll_area_id")->nullable();
            $table->unsignedBigInteger("staff_division_id")->nullable();
            $table->unsignedBigInteger("organizational_unit_id")->nullable();
            $table->unsignedBigInteger("superior_id")->nullable();
            $table->unsignedBigInteger("business_id")->nullable();
            $table->unsignedBigInteger("charge_id")->nullable();
            $table->unsignedBigInteger("composition_id")->nullable();
            $table->unsignedBigInteger("gender_id")->nullable();
            $table->unsignedBigInteger("type_document_id")->nullable();
            $table->string("personal_code",50);
            $table->string("names",100);
            $table->string("surnames",100);
            $table->string("numdoc",20);
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
            $table->boolean("grant")->nullable();
            $table->datetimes();
            $table->softDeletesDatetime();
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
