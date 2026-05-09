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
        'nama_petugas',
        'keluhan',
        'riwayat_pasien',
        'status_hamil',
    ];

    protected $casts = [
        'status_hamil' => 'boolean',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}