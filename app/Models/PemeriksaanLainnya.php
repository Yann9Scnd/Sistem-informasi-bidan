<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanLainnya extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_lainnya';

    protected $fillable = [
        'pasien_id',
        'hemoglobin',
        'golongan_darah_lab',
        'rhesus',
        'gula_darah',
        'protein_urine',
        'hiv_status',
        'hepatitis_b',
        'catatan_lainnya',
        'tindakan',
        'diagnosa',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}