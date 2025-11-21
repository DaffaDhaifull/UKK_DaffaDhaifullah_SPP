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
            $table->unsignedBigInteger('petugas_id')->nullable();
            $table->string('username', 100)->nullable();
            $table->string('ip_address', 50)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('waktu_login')->useCurrent();

            $table->foreign('petugas_id')->references('id_petugas')->on('petugas')->nullOnDelete();
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
