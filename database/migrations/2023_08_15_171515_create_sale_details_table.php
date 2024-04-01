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
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("sale_id");
            $table->unsignedBigInteger("product_id");
            $table->string("product_name",250)->nullable();
            $table->decimal("quantity",11,2)->nullable();
            $table->decimal("sale_price",11,2)->nullable();
            $table->decimal("total",11,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
