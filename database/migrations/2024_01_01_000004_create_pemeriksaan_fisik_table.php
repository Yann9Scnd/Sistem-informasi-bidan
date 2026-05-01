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
            // Tanda-tanda vital
            $table->unsignedSmallInteger('tekanan_darah_sistolik');
            $table->unsignedSmallInteger('tekanan_darah_diastolik');
            $table->unsignedSmallInteger('nadi')->comment('denyut/menit');
            $table->decimal('suhu', 4, 1)->comment('derajat Celsius');
            $table->unsignedTinyInteger('pernapasan')->comment('napas/menit');
            // Antropometri
            $table->decimal('berat_badan', 5, 1)->comment('kg');
            $table->decimal('tinggi_badan', 5, 1)->comment('cm');
            // Kebidanan
            $table->decimal('lingkar_perut', 5, 1)->nullable()->comment('cm');
            $table->decimal('tinggi_fundus', 5, 1)->nullable()->comment('cm');
            $table->unsignedSmallInteger('denyut_jantung_janin')->nullable()->comment('dpm');
            $table->string('presentasi_janin', 50)->nullable();
            $table->text('catatan_fisik')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_fisik');
    }
};