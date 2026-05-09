<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    use HasFactory;

    protected $table = 'diagnosis';

    protected $fillable = [
        'pasien_id',
        'diagnosa',
        'resep_obat',
        'edukasi',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}
