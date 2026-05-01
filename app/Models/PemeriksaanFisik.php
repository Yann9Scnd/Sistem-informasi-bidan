<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanFisik extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_fisik';

    protected $fillable = [
        'pasien_id',
        'tekanan_darah_sistolik',
        'tekanan_darah_diastolik',
        'nadi',
        'suhu',
        'pernapasan',
        'berat_badan',
        'tinggi_badan',
        'lingkar_perut',
        'tinggi_fundus',
        'denyut_jantung_janin',
        'presentasi_janin',
        'catatan_fisik',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    /**
     * Hitung IMT (Indeks Massa Tubuh).
     */
    public function getImtAttribute(): ?float
    {
        if ($this->berat_badan && $this->tinggi_badan) {
            $tinggiM = $this->tinggi_badan / 100;
            return round($this->berat_badan / ($tinggiM * $tinggiM), 1);
        }
        return null;
    }

    /**
     * Tekanan darah format "120/80".
     */
    public function getTekananDarahAttribute(): string
    {
        return $this->tekanan_darah_sistolik . '/' . $this->tekanan_darah_diastolik;
    }
}