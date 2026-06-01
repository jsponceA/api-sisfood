<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('worker_fingerprints', function (Blueprint $table) {
            $table->longText('template_data')->nullable()->after('capture_metadata');
            $table->string('template_engine', 100)->nullable()->after('template_data');
            $table->string('template_version', 100)->nullable()->after('template_engine');
            $table->string('template_hash', 191)->nullable()->after('template_version');
            $table->timestamp('template_created_at')->nullable()->after('template_hash');
            $table->boolean('is_active')->default(true)->after('template_created_at');
        });
    }

    public function down(): void
    {
        Schema::table('worker_fingerprints', function (Blueprint $table) {
            $table->dropColumn([
                'template_data',
                'template_engine',
                'template_version',
                'template_hash',
                'template_created_at',
                'is_active',
            ]);
        });
    }
};
