<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anamnesa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            $table->string('nama_petugas', 100)->comment('Nama bidan/petugas pemeriksa');
            $table->text('keluhan');
            $table->text('riwayat_pasien')->nullable()->comment('Status riwayat penyakit pasien');
            $table->boolean('status_hamil')->default(false)->comment('Status kehamilan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anamnesa');
    }
};