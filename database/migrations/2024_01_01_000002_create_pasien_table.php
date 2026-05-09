<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique()->comment('Nomor Induk Kependudukan');
            $table->unsignedInteger('no_urut')->comment('Urutan pendaftaran per hari');
            $table->string('nama', 100);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('nama_ortu', 100)->nullable()->comment('Nama orang tua kandung');
            $table->string('no_telp', 15);
            $table->enum('poli', ['KIA', 'KB', 'MTBS'])->default('KIA')->comment('Poli tujuan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};