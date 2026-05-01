<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan_lainnya', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            // Lab
            $table->decimal('hemoglobin', 4, 1)->nullable()->comment('g/dL');
            $table->enum('golongan_darah_lab', ['A', 'B', 'AB', 'O'])->nullable();
            $table->enum('rhesus', ['Positif', 'Negatif'])->nullable();
            $table->decimal('gula_darah', 5, 1)->nullable()->comment('mg/dL');
            $table->enum('protein_urine', ['Negatif', '+1', '+2', '+3', '+4'])->nullable();
            $table->enum('hiv_status', ['Non Reaktif', 'Reaktif', 'Tidak Diperiksa'])->default('Tidak Diperiksa');
            $table->enum('hepatitis_b', ['Non Reaktif', 'Reaktif', 'Tidak Diperiksa'])->default('Tidak Diperiksa');
            // Klinis
            $table->text('catatan_lainnya')->nullable();
            $table->text('tindakan')->nullable();
            $table->text('diagnosa')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_lainnya');
    }
};