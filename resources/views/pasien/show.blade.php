@extends('layouts.app')
@section('title', 'Detail Pasien')
@section('content')

<div class="page-header">
  <h1>👤 Detail Pasien</h1>
  <p>Informasi lengkap pasien</p>
</div>

<div class="card" style="margin-bottom:20px">
  <div class="card-header">
    <div class="card-title">📋 Identitas Pasien</div>
    <div style="display:flex;gap:8px">
      <a href="{{ route('anamnesa.step1', $pasien) }}" class="btn btn-green" style="font-size:13px">🩺 Mulai Pemeriksaan</a>
      <a href="{{ route('pasien.edit', $pasien) }}" class="btn btn-pink" style="font-size:13px">✏️ Edit</a>
    </div>
  </div>
  <div class="card-body">
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:16px">
      <div class="info-item"><span class="info-label">NIK</span><span class="info-value" style="font-family:monospace">{{ $pasien->nik }}</span></div>
      <div class="info-item"><span class="info-label">No. Urut</span><span class="info-value">{{ str_pad($pasien->no_urut, 3, '0', STR_PAD_LEFT) }}</span></div>
      <div class="info-item"><span class="info-label">Nama</span><span class="info-value">{{ $pasien->nama }}</span></div>
      <div class="info-item"><span class="info-label">Jenis Kelamin</span><span class="info-value">{{ $pasien->jenis_kelamin }}</span></div>
      <div class="info-item"><span class="info-label">TTL</span><span class="info-value">{{ $pasien->ttl }}</span></div>
      <div class="info-item"><span class="info-label">Umur</span><span class="info-value">{{ $pasien->umur }}</span></div>
      <div class="info-item" style="grid-column:1/-1"><span class="info-label">Alamat</span><span class="info-value">{{ $pasien->alamat }}</span></div>
      <div class="info-item"><span class="info-label">Nama Orang Tua</span><span class="info-value">{{ $pasien->nama_ortu ?: '-' }}</span></div>
      <div class="info-item"><span class="info-label">No. Telp</span><span class="info-value">{{ $pasien->no_telp }}</span></div>
      <div class="info-item"><span class="info-label">Poli</span><span class="info-value"><span class="badge {{ $pasien->poli === 'KIA' ? 'badge-green' : ($pasien->poli === 'KB' ? 'badge-purple' : 'badge-orange') }}">{{ $pasien->poli }}</span></span></div>
    </div>
  </div>
</div>

{{-- RIWAYAT ANAMNESA --}}
<div class="card" style="margin-bottom:20px">
  <div class="card-header"><div class="card-title">🩺 Riwayat Anamnesa</div></div>
  <div class="card-body" style="padding:0;overflow-x:auto">
    <table class="data-table">
      <thead><tr><th>Tanggal</th><th>Petugas</th><th>Keluhan</th><th>Riwayat</th><th>Hamil</th></tr></thead>
      <tbody>
        @forelse($pasien->anamnesa->sortByDesc('created_at') as $a)
        <tr>
          <td style="font-size:12px;white-space:nowrap">{{ $a->created_at->format('d/m/Y H:i') }}</td>
          <td>{{ $a->nama_petugas }}</td>
          <td>{{ Str::limit($a->keluhan, 60) }}</td>
          <td>{{ Str::limit($a->riwayat_pasien ?: '-', 40) }}</td>
          <td><span class="badge {{ $a->status_hamil ? 'badge-pink' : 'badge-gray' }}">{{ $a->status_hamil ? 'Ya' : 'Tidak' }}</span></td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;padding:20px;color:var(--text-light)">Belum ada data</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- RIWAYAT PEMERIKSAAN FISIK --}}
<div class="card" style="margin-bottom:20px">
  <div class="card-header"><div class="card-title">📊 Riwayat Pemeriksaan Fisik</div></div>
  <div class="card-body" style="padding:0;overflow-x:auto">
    <table class="data-table">
      <thead><tr><th>Tanggal</th><th>Kesadaran</th><th>TD</th><th>Nadi</th><th>Suhu</th><th>RR</th><th>TB</th><th>BB</th><th>LILA</th><th>LP</th><th>ANC</th></tr></thead>
      <tbody>
        @forelse($pasien->pemeriksaanFisik->sortByDesc('created_at') as $pf)
        <tr>
          <td style="font-size:12px;white-space:nowrap">{{ $pf->created_at->format('d/m/Y H:i') }}</td>
          <td>{{ $pf->kesadaran }}</td>
          <td>{{ $pf->tekanan_darah }}</td>
          <td>{{ $pf->nadi }}</td>
          <td>{{ $pf->suhu }}°C</td>
          <td>{{ $pf->nafas_rr }}</td>
          <td>{{ $pf->tinggi_badan }} cm</td>
          <td>{{ $pf->berat_badan }} kg</td>
          <td>{{ $pf->lingkar_lengan ? $pf->lingkar_lengan.' cm' : '-' }}</td>
          <td>{{ $pf->lingkar_perut ? $pf->lingkar_perut.' cm' : '-' }}</td>
          <td><span class="badge {{ $pf->anc_terpadu === 'Sudah' ? 'badge-green' : 'badge-gray' }}">{{ $pf->anc_terpadu }}</span></td>
        </tr>
        @empty
        <tr><td colspan="11" style="text-align:center;padding:20px;color:var(--text-light)">Belum ada data</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- RIWAYAT DIAGNOSIS --}}
<div class="card" style="margin-bottom:20px">
  <div class="card-header"><div class="card-title">💊 Riwayat Diagnosis & Resep</div></div>
  <div class="card-body" style="padding:0;overflow-x:auto">
    <table class="data-table">
      <thead><tr><th>Tanggal</th><th>Diagnosa</th><th>Resep Obat</th><th>Edukasi</th></tr></thead>
      <tbody>
        @forelse($pasien->diagnosis->sortByDesc('created_at') as $d)
        <tr>
          <td style="font-size:12px;white-space:nowrap">{{ $d->created_at->format('d/m/Y H:i') }}</td>
          <td>{{ Str::limit($d->diagnosa, 60) }}</td>
          <td>{{ Str::limit($d->resep_obat ?: '-', 60) }}</td>
          <td>{{ Str::limit($d->edukasi ?: '-', 60) }}</td>
        </tr>
        @empty
        <tr><td colspan="4" style="text-align:center;padding:20px;color:var(--text-light)">Belum ada data</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<a href="{{ route('pasien.index') }}" class="btn btn-gray" style="margin-bottom:24px">← Kembali ke Daftar</a>
@endsection
