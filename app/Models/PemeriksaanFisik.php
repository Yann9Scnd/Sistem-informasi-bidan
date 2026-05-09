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
        'kesadaran',
        'td_sistolik',
        'td_diastolik',
        'nadi',
        'suhu',
        'nafas_rr',
        'tinggi_badan',
        'berat_badan',
        'lingkar_lengan',
        'lingkar_perut',
        'anc_terpadu',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    /**
     * Tekanan darah format "120/80 mmHg".
     */
    public function getTekananDarahAttribute(): string
    {
        return $this->td_sistolik . '/' . $this->td_diastolik . ' mmHg';
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
}