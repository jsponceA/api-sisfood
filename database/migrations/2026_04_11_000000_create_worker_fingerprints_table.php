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
        Schema::create('worker_fingerprints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained()->cascadeOnDelete();
            $table->string('finger_label', 100)->nullable();
            $table->unsignedTinyInteger('sample_format');
            $table->longText('sample_data');
            $table->longText('image_data')->nullable();
            $table->string('device_uid', 191)->nullable();
            $table->unsignedSmallInteger('quality')->nullable();
            $table->json('capture_metadata')->nullable();
            $table->datetimes();
            $table->softDeletesDatetime();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('worker_fingerprints');
    }
};
