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
        Schema::create('siswa', function (Blueprint $table) {
            $table->char('nisn',10)->primary();
            $table->char('nis',8);
            $table->string('nama',35);
            $table->integer('id_kelas');
            $table->text('alamat');
            $table->string('no_telepon',13);
            $table->string('password');
            $table->integer('id_spp');
            $table->dateTime('last_login')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('last_logout')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();

            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('id_spp')->references('id_spp')->on('spp')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
