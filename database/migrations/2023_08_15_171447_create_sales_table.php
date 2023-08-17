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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("worker_id");
            $table->dateTime("sale_date")->nullable();
            $table->string("serie",20)->nullable();
            $table->string("num_document",20)->nullable();
            $table->decimal("total_sale",11,2)->nullable();
            $table->decimal("total_igv",11,2)->nullable();
            $table->decimal("total_dsct_form",11,2)->nullable();
            $table->decimal("total_pay_company",11,2)->nullable();
            $table->string("deal_in_form",100)->nullable();
            $table->enum("pay_type",["CREDITO","EFECTIVO"]);
            $table->datetimes();
            $table->softDeletesDatetime();
            $table->foreign("worker_id")->references("id")->on("workers");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
