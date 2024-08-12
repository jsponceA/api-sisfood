<?php

use App\Models\Product;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("category_id")->nullable();
            $table->string("name",255)->unique();
            $table->string("internal_code",50)->nullable();
            $table->string("barcode",100)->nullable();
            $table->string("image")->nullable();
            $table->decimal("purchase_price",11,2)->nullable();
            $table->decimal("sale_price",11,2)->nullable();
            $table->decimal("worker_price",11,2)->nullable();
            $table->decimal("igv_price",11,2)->nullable();
            $table->decimal("company_price",11,2)->nullable();
            $table->boolean("handle_stock")->nullable();
            $table->decimal("current_stock",11,2)->nullable();
            $table->date("expiration_date")->nullable();
            $table->datetimes();
            $table->softDeletesDatetime();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
