<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'nik',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'no_hp',
        'alamat_tinggal',
        'alamat_ktp',
        'golongan_darah',
        'agama',
        'pekerjaan',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function anamnesa()
    {
        return $this->hasOne(Anamnesa::class);
    }

    public function pemeriksaanFisik()
    {
        return $this->hasOne(PemeriksaanFisik::class);
    }

    public function pemeriksaanLainnya()
    {
        return $this->hasOne(PemeriksaanLainnya::class);
    }

    // ─── Accessors ────────────────────────────────────────────────────────────

    /**
     * Hitung umur dari tanggal lahir.
     */
    public function getUmurAttribute(): string
    {
        return $this->tanggal_lahir
            ? $this->tanggal_lahir->age . ' thn'
            : '-';
    }

    /**
     * Inisial nama untuk avatar.
     */
    public function getInisialAttribute(): string
    {
        $words = explode(' ', $this->nama);
        $init  = strtoupper(substr($words[0], 0, 1));
        if (isset($words[1])) {
            $init .= strtoupper(substr($words[1], 0, 1));
        }
        return $init;
    }

    /**
     * Tanggal lahir format Indonesia.
     */
    public function getTanggalLahirFormatAttribute(): string
    {
        if (!$this->tanggal_lahir) return '-';
        $months = [
            1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',
            7=>'Jul',8=>'Agt',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des',
        ];
        return $this->tanggal_lahir->day . ' '
            . $months[$this->tanggal_lahir->month] . ' '
            . $this->tanggal_lahir->year;
    }
}