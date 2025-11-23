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
        Schema::create('log_login', function (Blueprint $table) {
            $table->id('id_log');
            $table->string('user_id',30);
            $table->string('username', 30);
            $table->enum('role', ['admin','petugas', 'siswa']);
            $table->enum('aktivitas', ['login', 'logout']);
            $table->dateTime('waktu')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_login');
    }
};
