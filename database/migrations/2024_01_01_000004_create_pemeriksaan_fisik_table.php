<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan_fisik', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            // Kesadaran
            $table->enum('kesadaran', ['Komposmentis', 'Somnolen', 'Sopor', 'Koma'])->default('Komposmentis');
            // Tanda vital
            $table->unsignedSmallInteger('td_sistolik')->comment('Tekanan darah sistolik mmHg');
            $table->unsignedSmallInteger('td_diastolik')->comment('Tekanan darah diastolik mmHg');
            $table->unsignedSmallInteger('nadi')->comment('Nadi per menit');
            $table->decimal('suhu', 4, 1)->comment('Suhu tubuh °C');
            $table->unsignedSmallInteger('nafas_rr')->comment('Respiratory Rate per menit');
            // Antropometri
            $table->decimal('tinggi_badan', 5, 1)->comment('cm');
            $table->decimal('berat_badan', 5, 1)->comment('kg');
            $table->decimal('lingkar_lengan', 5, 1)->nullable()->comment('LILA cm');
            $table->decimal('lingkar_perut', 5, 1)->nullable()->comment('cm');
            // ANC
            $table->enum('anc_terpadu', ['Belum', 'Sudah'])->default('Belum');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_fisik');
    }
};