<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anamnesa extends Model
{
    use HasFactory;

    protected $table = 'anamnesa';

    protected $fillable = [
        'pasien_id',
        'keluhan_utama',
        'riwayat_penyakit',
        'riwayat_keluarga',
        'alergi',
        'obat_saat_ini',
        'hari_pertama_haid',
        'gravida',
        'para',
        'abortus',
    ];

    protected $casts = [
        'hari_pertama_haid' => 'date',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}