@extends('layouts.app')
@section('title', 'Detail Pemeriksaan')
@section('content')

<div class="page-header">
  <h1>📊 Detail Pemeriksaan Fisik</h1>
  <p>Pasien: {{ $pemeriksaan->pasien->nama ?? '-' }}</p>
</div>

<div class="card" style="margin-bottom:20px">
  <div class="card-header">
    <div class="card-title">🏥 Data Pemeriksaan</div>
    <span style="font-size:12px;color:var(--text-light)">{{ $pemeriksaan->created_at->format('d/m/Y H:i') }}</span>
  </div>
  <div class="card-body">
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px">
      <div class="info-item"><span class="info-label">Pasien</span><span class="info-value">{{ $pemeriksaan->pasien->nama ?? '-' }}</span></div>
      <div class="info-item"><span class="info-label">NIK</span><span class="info-value" style="font-family:monospace">{{ $pemeriksaan->pasien->nik ?? '-' }}</span></div>
      <div class="info-item"><span class="info-label">Kesadaran</span><span class="info-value">{{ $pemeriksaan->kesadaran }}</span></div>
      <div class="info-item"><span class="info-label">Tekanan Darah</span><span class="info-value">{{ $pemeriksaan->tekanan_darah }}</span></div>
      <div class="info-item"><span class="info-label">Nadi</span><span class="info-value">{{ $pemeriksaan->nadi }} /mnt</span></div>
      <div class="info-item"><span class="info-label">Suhu</span><span class="info-value">{{ $pemeriksaan->suhu }} °C</span></div>
      <div class="info-item"><span class="info-label">Nafas (RR)</span><span class="info-value">{{ $pemeriksaan->nafas_rr }} /mnt</span></div>
      <div class="info-item"><span class="info-label">Tinggi Badan</span><span class="info-value">{{ $pemeriksaan->tinggi_badan }} cm</span></div>
      <div class="info-item"><span class="info-label">Berat Badan</span><span class="info-value">{{ $pemeriksaan->berat_badan }} kg</span></div>
      <div class="info-item"><span class="info-label">IMT</span><span class="info-value">{{ $pemeriksaan->imt ?? '-' }}</span></div>
      <div class="info-item"><span class="info-label">Lingkar Lengan</span><span class="info-value">{{ $pemeriksaan->lingkar_lengan ? $pemeriksaan->lingkar_lengan.' cm' : '-' }}</span></div>
      <div class="info-item"><span class="info-label">Lingkar Perut</span><span class="info-value">{{ $pemeriksaan->lingkar_perut ? $pemeriksaan->lingkar_perut.' cm' : '-' }}</span></div>
      <div class="info-item"><span class="info-label">ANC Terpadu</span><span class="info-value"><span class="badge {{ $pemeriksaan->anc_terpadu === 'Sudah' ? 'badge-green' : 'badge-gray' }}">{{ $pemeriksaan->anc_terpadu }}</span></span></div>
    </div>
  </div>
</div>

<a href="{{ route('pemeriksaan.index') }}" class="btn btn-gray" style="margin-bottom:24px">← Kembali</a>

@endsection
