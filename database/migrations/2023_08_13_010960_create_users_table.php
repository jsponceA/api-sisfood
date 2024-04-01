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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("rol_id");
            $table->unsignedBigInteger("branch_id");
            $table->string('username',50)->unique();
            $table->string('password');
            $table->string('email',100)->nullable();
            $table->string('photo')->nullable();
            $table->rememberToken();
            $table->datetimes();
            $table->softDeletesDatetime();
        });

        \App\Models\User::query()->create([
            'rol_id' => 1,
            'branch_id' => 1,
            'username' => "admin",
            'password' => 123456,
            'email' => "adming@gmail.com",
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
