<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
.kop { text-align: center; border-bottom: 3px double #E879A0; padding-bottom: 16px; margin-bottom: 20px; }
.kop h1 { font-size: 18px; color: #C2185B; margin: 0 0 4px; }
.kop h2 { font-size: 13px; font-weight: 600; color: #4A5568; margin: 0 0 4px; }
.kop p { font-size: 10px; color: #718096; margin: 0; }
.section { margin-bottom: 18px; }
.section-title { font-size: 13px; font-weight: 700; color: #C2185B; border-bottom: 1px solid #F8C8DC; padding-bottom: 4px; margin-bottom: 10px; }
table { width: 100%; border-collapse: collapse; font-size: 11px; }
table th, table td { padding: 6px 10px; text-align: left; border: 1px solid #EED5E0; }
table th { background: #FDECEF; font-weight: 600; color: #4A5568; width: 35%; }
table td { color: #2D3748; }
.footer { text-align: center; font-size: 9px; color: #718096; margin-top: 30px; border-top: 1px solid #EED5E0; padding-top: 10px; }
.ttd { margin-top: 40px; text-align: right; padding-right: 40px; }
.ttd .nama { margin-top: 60px; font-weight: 700; text-decoration: underline; }
</style>
</head>
<body>

<div class="kop">
  <h1>PMB Sri Andayani, Amd.Keb</h1>
  <h2>Praktik Mandiri Bidan</h2>
  <p>Sistem Informasi Klinik Bidan</p>
</div>

<div style="text-align:center;margin-bottom:18px">
  <strong style="font-size:14px">HASIL PEMERIKSAAN PASIEN</strong><br>
  <span style="font-size:10px;color:#718096">Dicetak: {{ now()->isoFormat('D MMMM Y, HH:mm') }} WIB</span>
</div>

{{-- Data Pasien --}}
<div class="section">
  <div class="section-title">Data Pasien</div>
  <table>
    <tr><th>NIK</th><td>{{ $pasien->nik }}</td></tr>
    <tr><th>Nama</th><td>{{ $pasien->nama }}</td></tr>
    <tr><th>Jenis Kelamin</th><td>{{ $pasien->jenis_kelamin }}</td></tr>
    <tr><th>Tempat, Tanggal Lahir</th><td>{{ $pasien->ttl }}</td></tr>
    <tr><th>Umur</th><td>{{ $pasien->umur }}</td></tr>
    <tr><th>Alamat</th><td>{{ $pasien->alamat }}</td></tr>
    <tr><th>Nama Orang Tua</th><td>{{ $pasien->nama_ortu ?: '-' }}</td></tr>
    <tr><th>No. Telepon</th><td>{{ $pasien->no_telp }}</td></tr>
    <tr><th>Poli</th><td>{{ $pasien->poli }}</td></tr>
  </table>
</div>

{{-- Anamnese --}}
@if($pasien->latestAnamnesa)
<div class="section">
  <div class="section-title">Anamnese</div>
  <table>
    <tr><th>Tanggal Periksa</th><td>{{ $pasien->latestAnamnesa->created_at->isoFormat('D MMMM Y, HH:mm') }}</td></tr>
    <tr><th>Nama Petugas</th><td>{{ $pasien->latestAnamnesa->nama_petugas }}</td></tr>
    <tr><th>Keluhan</th><td>{{ $pasien->latestAnamnesa->keluhan }}</td></tr>
    <tr><th>Riwayat Pasien</th><td>{{ $pasien->latestAnamnesa->riwayat_pasien ?: '-' }}</td></tr>
    <tr><th>Status Kehamilan</th><td>{{ $pasien->latestAnamnesa->status_hamil ? 'Ya' : 'Tidak' }}</td></tr>
  </table>
</div>
@endif

{{-- Pemeriksaan Fisik --}}
@if($pasien->latestPemeriksaanFisik)
<div class="section">
  <div class="section-title">Pemeriksaan Fisik</div>
  <table>
    <tr><th>Kesadaran</th><td>{{ $pasien->latestPemeriksaanFisik->kesadaran }}</td></tr>
    <tr><th>Tekanan Darah</th><td>{{ $pasien->latestPemeriksaanFisik->tekanan_darah }}</td></tr>
    <tr><th>Nadi</th><td>{{ $pasien->latestPemeriksaanFisik->nadi }} x/menit</td></tr>
    <tr><th>Suhu</th><td>{{ $pasien->latestPemeriksaanFisik->suhu }} °C</td></tr>
    <tr><th>Nafas (RR)</th><td>{{ $pasien->latestPemeriksaanFisik->nafas_rr }} x/menit</td></tr>
    <tr><th>Tinggi Badan</th><td>{{ $pasien->latestPemeriksaanFisik->tinggi_badan }} cm</td></tr>
    <tr><th>Berat Badan</th><td>{{ $pasien->latestPemeriksaanFisik->berat_badan }} kg</td></tr>
    <tr><th>Lingkar Lengan (LILA)</th><td>{{ $pasien->latestPemeriksaanFisik->lingkar_lengan ? $pasien->latestPemeriksaanFisik->lingkar_lengan.' cm' : '-' }}</td></tr>
    <tr><th>Lingkar Perut</th><td>{{ $pasien->latestPemeriksaanFisik->lingkar_perut ? $pasien->latestPemeriksaanFisik->lingkar_perut.' cm' : '-' }}</td></tr>
    <tr><th>ANC Terpadu</th><td>{{ $pasien->latestPemeriksaanFisik->anc_terpadu }}</td></tr>
  </table>
</div>
@endif

{{-- Diagnosis --}}
@if($pasien->latestDiagnosis)
<div class="section">
  <div class="section-title">Diagnosis & Resep Obat</div>
  <table>
    <tr><th>Diagnosa</th><td>{{ $pasien->latestDiagnosis->diagnosa }}</td></tr>
    <tr><th>Resep Obat</th><td>{{ $pasien->latestDiagnosis->resep_obat ?: '-' }}</td></tr>
    <tr><th>Edukasi Pasien</th><td>{{ $pasien->latestDiagnosis->edukasi ?: '-' }}</td></tr>
  </table>
</div>
@endif

<div class="ttd">
  <p>Mengetahui,</p>
  <p>Bidan Pemeriksa</p>
  <p class="nama">{{ $pasien->latestAnamnesa?->nama_petugas ?? 'Sri Andayani, Amd.Keb' }}</p>
</div>

<div class="footer">
  Dokumen ini dicetak secara otomatis dari Sistem Informasi PMB Sri Andayani, Amd.Keb<br>
  &copy; {{ date('Y') }} — Semua data bersifat rahasia
</div>

</body>
</html>
