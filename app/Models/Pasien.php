<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Pasien extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pasien';

    protected $fillable = [
        'nik',
        'no_urut',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'nama_ortu',
        'no_telp',
        'poli',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // ─── Relationships ────────────────────────────────────────────────────────

    public function anamnesa()
    {
        return $this->hasMany(Anamnesa::class);
    }

    public function latestAnamnesa()
    {
        return $this->hasOne(Anamnesa::class)->latestOfMany();
    }

    public function pemeriksaanFisik()
    {
        return $this->hasMany(PemeriksaanFisik::class);
    }

    public function latestPemeriksaanFisik()
    {
        return $this->hasOne(PemeriksaanFisik::class)->latestOfMany();
    }

    public function diagnosis()
    {
        return $this->hasMany(Diagnosis::class);
    }

    public function latestDiagnosis()
    {
        return $this->hasOne(Diagnosis::class)->latestOfMany();
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

    /**
     * Tempat, Tanggal Lahir format.
     */
    public function getTtlAttribute(): string
    {
        $tempat = $this->tempat_lahir ?: '-';
        return $tempat . ', ' . $this->tanggal_lahir_format;
    }

    /**
     * Generate nomor urut otomatis per hari.
     */
    public static function generateNoUrut(): int
    {
        $today = Carbon::today();
        $lastUrut = static::whereDate('created_at', $today)->max('no_urut');
        return ($lastUrut ?? 0) + 1;
    }
}