<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnosis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            $table->text('diagnosa')->comment('Diagnosa penyakit');
            $table->text('resep_obat')->nullable()->comment('Resep obat');
            $table->text('edukasi')->nullable()->comment('Edukasi untuk pasien');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnosis');
    }
};