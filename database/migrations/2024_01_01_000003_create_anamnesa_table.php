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
            $table->text('keluhan_utama');
            $table->text('riwayat_penyakit')->nullable();
            $table->text('riwayat_keluarga')->nullable();
            $table->string('alergi', 200)->nullable();
            $table->text('obat_saat_ini')->nullable();
            // Data kebidanan
            $table->date('hari_pertama_haid')->nullable()->comment('HPHT');
            $table->unsignedTinyInteger('gravida')->nullable()->comment('Jumlah kehamilan');
            $table->unsignedTinyInteger('para')->nullable()->comment('Jumlah persalinan');
            $table->unsignedTinyInteger('abortus')->nullable()->comment('Jumlah keguguran');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anamnesa');
    }
};