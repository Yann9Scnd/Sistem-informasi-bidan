@extends('layouts.app')
@section('title', 'Pemeriksaan Selesai')
@section('content')

<div class="page-header">
  <h1>✅ Pemeriksaan Selesai</h1>
  <p>Ringkasan data pemeriksaan pasien {{ $pasien->nama }}</p>
</div>

<div class="stepper">
  <div class="step-item"><div class="step-circle done">✓</div><span class="step-label done">Anamnesa</span></div>
  <div class="step-line done"></div>
  <div class="step-item"><div class="step-circle done">✓</div><span class="step-label done">Pemeriksaan Fisik</span></div>
  <div class="step-line done"></div>
  <div class="step-item"><div class="step-circle done">✓</div><span class="step-label done">Diagnosis</span></div>
</div>

{{-- ANAMNESA SUMMARY --}}
<div class="card" style="margin-bottom:16px">
  <div class="card-header"><div class="card-title">🩺 Anamnesa</div></div>
  <div class="card-body">
    @if($pasien->latestAnamnesa)
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
      <div class="info-item"><span class="info-label">Petugas</span><span class="info-value">{{ $pasien->latestAnamnesa->nama_petugas }}</span></div>
      <div class="info-item"><span class="info-label">Status Hamil</span><span class="info-value"><span class="badge {{ $pasien->latestAnamnesa->status_hamil ? 'badge-pink' : 'badge-gray' }}">{{ $pasien->latestAnamnesa->status_hamil ? 'Ya' : 'Tidak' }}</span></span></div>
      <div class="info-item" style="grid-column:1/-1"><span class="info-label">Keluhan</span><span class="info-value">{{ $pasien->latestAnamnesa->keluhan }}</span></div>
      <div class="info-item" style="grid-column:1/-1"><span class="info-label">Riwayat Pasien</span><span class="info-value">{{ $pasien->latestAnamnesa->riwayat_pasien ?: '-' }}</span></div>
    </div>
    @else
    <p style="color:var(--text-light)">Data belum tersedia</p>
    @endif
  </div>
</div>

{{-- PEMERIKSAAN FISIK SUMMARY --}}
<div class="card" style="margin-bottom:16px">
  <div class="card-header"><div class="card-title">📊 Pemeriksaan Fisik</div></div>
  <div class="card-body">
    @if($pf = $pasien->latestPemeriksaanFisik)
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:12px">
      <div class="info-item"><span class="info-label">Kesadaran</span><span class="info-value">{{ $pf->kesadaran }}</span></div>
      <div class="info-item"><span class="info-label">Tekanan Darah</span><span class="info-value">{{ $pf->tekanan_darah }}</span></div>
      <div class="info-item"><span class="info-label">Nadi</span><span class="info-value">{{ $pf->nadi }} /mnt</span></div>
      <div class="info-item"><span class="info-label">Suhu</span><span class="info-value">{{ $pf->suhu }} °C</span></div>
      <div class="info-item"><span class="info-label">Nafas (RR)</span><span class="info-value">{{ $pf->nafas_rr }} /mnt</span></div>
      <div class="info-item"><span class="info-label">Tinggi Badan</span><span class="info-value">{{ $pf->tinggi_badan }} cm</span></div>
      <div class="info-item"><span class="info-label">Berat Badan</span><span class="info-value">{{ $pf->berat_badan }} kg</span></div>
      <div class="info-item"><span class="info-label">Lingkar Lengan</span><span class="info-value">{{ $pf->lingkar_lengan ? $pf->lingkar_lengan.' cm' : '-' }}</span></div>
      <div class="info-item"><span class="info-label">Lingkar Perut</span><span class="info-value">{{ $pf->lingkar_perut ? $pf->lingkar_perut.' cm' : '-' }}</span></div>
      <div class="info-item"><span class="info-label">ANC Terpadu</span><span class="info-value"><span class="badge {{ $pf->anc_terpadu === 'Sudah' ? 'badge-green' : 'badge-gray' }}">{{ $pf->anc_terpadu }}</span></span></div>
    </div>
    @else
    <p style="color:var(--text-light)">Data belum tersedia</p>
    @endif
  </div>
</div>

{{-- DIAGNOSIS SUMMARY --}}
<div class="card" style="margin-bottom:20px">
  <div class="card-header"><div class="card-title">💊 Diagnosis & Resep</div></div>
  <div class="card-body">
    @if($dx = $pasien->latestDiagnosis)
    <div style="display:grid;grid-template-columns:1fr;gap:12px">
      <div class="info-item"><span class="info-label">Diagnosa</span><span class="info-value">{{ $dx->diagnosa }}</span></div>
      <div class="info-item"><span class="info-label">Resep Obat</span><span class="info-value">{{ $dx->resep_obat ?: '-' }}</span></div>
      <div class="info-item"><span class="info-label">Edukasi</span><span class="info-value">{{ $dx->edukasi ?: '-' }}</span></div>
    </div>
    @else
    <p style="color:var(--text-light)">Data belum tersedia</p>
    @endif
  </div>
</div>

<div style="display:flex;gap:12px;margin-bottom:24px">
  <a href="{{ route('pasien.show', $pasien) }}" class="btn btn-pink">👤 Lihat Detail Pasien</a>
  <a href="{{ route('pasien.index') }}" class="btn btn-gray">← Kembali ke Daftar</a>
</div>

@endsection
