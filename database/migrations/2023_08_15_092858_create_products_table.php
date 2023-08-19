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
            $table->string("name",255);
            $table->enum("category",["BEBIDAS","COMIDAS","SNACK","EXTRAS"]);
            $table->string("barcode",100)->nullable();
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


        Product::query()->create([
            "name" => "DESAYUNO",
            "category" => "COMIDAS",
            "barcode" => "DESAYUNO123",
            "purchase_price" => 2.5,
            "sale_price" => 4.2,
            "worker_price" => 4.2,
            "igv_price" => 4.96,
            "company_price" => 0.76,
        ]);

        Product::query()->create([
            "name" => "ALMUERZO",
            "category" => "COMIDAS",
            "barcode" => "ALMUERZO123",
            "purchase_price" => 7.5,
            "sale_price" => 9.5,
            "worker_price" => 3,
            "igv_price" => 11.21,
            "company_price" => 8.21,
        ]);

        Product::query()->create([
            "name" => "CENA",
            "category" => "COMIDAS",
            "barcode" => "CENA123",
            "purchase_price" => 7.5,
            "sale_price" => 9.5,
            "worker_price" => 3,
            "igv_price" => 11.21,
            "company_price" => 8.21,
        ]);


        Product::query()->create([
            "name" => "LOMO SALTADO",
            "category" => "EXTRAS",
            "barcode" => "LS123",
            "purchase_price" => 0,
            "sale_price" => 15,
            "worker_price" => 0,
            "igv_price" => 0,
            "company_price" => 8.0,
        ]);

        Product::query()->create([
            "name" => "POLLO SALTADO",
            "category" => "EXTRAS",
            "barcode" => "PL123",
            "purchase_price" => 0,
            "sale_price" => 15,
            "worker_price" => 0,
            "igv_price" => 0,
            "company_price" => 8.0,
        ]);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
