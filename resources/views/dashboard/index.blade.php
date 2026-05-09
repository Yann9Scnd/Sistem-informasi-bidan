@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="page-header">
  <h1>
    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="3" y="14" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="14" width="7" height="7" rx="1" stroke-width="2"/></svg>
    Dashboard
  </h1>
  <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong> 👋 — {{ now()->isoFormat('dddd, D MMMM Y') }}</p>
</div>

{{-- STAT CARDS --}}
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon pink">🤰</div>
    <div>
      <div class="stat-label">Total Pasien</div>
      <div class="stat-value">{{ $stats['total_pasien'] }}</div>
      <div class="stat-sub">↑ {{ $stats['pasien_baru_hari_ini'] }} baru hari ini</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green">🏥</div>
    <div>
      <div class="stat-label">Poli KIA</div>
      <div class="stat-value">{{ $stats['poli_kia'] }}</div>
      <div class="stat-sub">Kesehatan Ibu & Anak</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon blue">💊</div>
    <div>
      <div class="stat-label">Poli KB</div>
      <div class="stat-value">{{ $stats['poli_kb'] }}</div>
      <div class="stat-sub">Keluarga Berencana</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon orange">👶</div>
    <div>
      <div class="stat-label">MTBS</div>
      <div class="stat-value">{{ $stats['poli_mtbs'] }}</div>
      <div class="stat-sub">Balita Sakit 0-6 th</div>
    </div>
  </div>
</div>

{{-- CONTENT ROW --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

  {{-- Pasien Terbaru --}}
  <div class="card">
    <div class="card-header">
      <div class="card-title">👤 Pasien Terbaru</div>
      <a href="{{ route('pasien.index') }}" style="font-size:12px;color:var(--pink-accent);font-weight:600">Lihat Semua →</a>
    </div>
    <div class="card-body" style="padding:0">
      @forelse($pasien_terbaru as $p)
        <div style="display:flex;align-items:center;gap:12px;padding:14px 20px;border-bottom:1px solid #FAE8F0">
          <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--pink-accent),#C2185B);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:13px;flex-shrink:0">
            {{ $p->inisial }}
          </div>
          <div style="flex:1;min-width:0">
            <div style="font-weight:600;font-size:13px;color:var(--text-dark);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $p->nama }}</div>
            <div style="font-size:11px;color:var(--text-light)">{{ $p->nik }} · {{ $p->umur }}</div>
          </div>
          <span class="badge {{ $p->poli === 'KIA' ? 'badge-green' : ($p->poli === 'KB' ? 'badge-purple' : 'badge-orange') }}">
            {{ $p->poli }}
          </span>
        </div>
      @empty
        <div class="no-data" style="padding:40px">
          <h3>Belum ada pasien</h3>
          <p>Tambahkan pasien baru untuk memulai</p>
        </div>
      @endforelse
    </div>
  </div>

  {{-- Aksi Cepat --}}
  <div class="card">
    <div class="card-header">
      <div class="card-title">⚡ Aksi Cepat</div>
    </div>
    <div class="card-body">
      <div style="display:flex;flex-direction:column;gap:12px">
        <a href="{{ route('pasien.create') }}" class="quick-action-link" style="background:var(--pink-secondary);border:1.5px solid var(--pink-primary)">
          <span style="font-size:28px">➕</span>
          <div>
            <div style="font-weight:600;font-size:14px;color:var(--text-dark)">Daftarkan Pasien Baru</div>
            <div style="font-size:12px;color:var(--text-light)">Tambah data pasien ke sistem</div>
          </div>
        </a>
        <a href="{{ route('pelayanan.pilih-pasien') }}" class="quick-action-link" style="background:#F0FFF4;border:1.5px solid #C6F6D5">
          <span style="font-size:28px">🩺</span>
          <div>
            <div style="font-weight:600;font-size:14px;color:var(--text-dark)">Mulai Pemeriksaan</div>
            <div style="font-size:12px;color:var(--text-light)">Pilih pasien & mulai anamnese</div>
          </div>
        </a>
        <a href="{{ route('pemeriksaan.index') }}" class="quick-action-link" style="background:#EBF8FF;border:1.5px solid #BEE3F8">
          <span style="font-size:28px">📝</span>
          <div>
            <div style="font-weight:600;font-size:14px;color:var(--text-dark)">Data Pemeriksaan</div>
            <div style="font-size:12px;color:var(--text-light)">{{ $stats['pemeriksaan_hari_ini'] }} pemeriksaan hari ini</div>
          </div>
        </a>
        <a href="{{ url('/portal') }}" class="quick-action-link" style="background:#FAF5FF;border:1.5px solid #E9D5FF" target="_blank">
          <span style="font-size:28px">🔗</span>
          <div>
            <div style="font-weight:600;font-size:14px;color:var(--text-dark)">Portal Pasien</div>
            <div style="font-size:12px;color:var(--text-light)">Link untuk pasien cek hasil</div>
          </div>
        </a>
      </div>
    </div>
  </div>

</div>

{{-- PELAYANAN --}}
<div class="card" style="margin-top:20px">
  <div class="card-header">
    <div class="card-title">🏥 Pelayanan Klinik</div>
  </div>
  <div class="card-body">
    <div class="pelayanan-grid">
      <a href="{{ route('pasien.index', ['poli' => 'KIA']) }}" class="pelayanan-card" style="text-decoration:none">
        <div class="pelayanan-icon">🤰</div>
        <div class="pelayanan-title">Poli KIA</div>
        <div class="pelayanan-desc">Kesehatan Ibu & Anak</div>
      </a>
      <a href="{{ route('pasien.index', ['poli' => 'KB']) }}" class="pelayanan-card" style="text-decoration:none">
        <div class="pelayanan-icon">💊</div>
        <div class="pelayanan-title">Poli KB</div>
        <div class="pelayanan-desc">Keluarga Berencana</div>
      </a>
      <a href="{{ route('pasien.index', ['poli' => 'MTBS']) }}" class="pelayanan-card" style="text-decoration:none">
        <div class="pelayanan-icon">👶</div>
        <div class="pelayanan-title">MTBS</div>
        <div class="pelayanan-desc">Balita Sakit 0-6 tahun</div>
      </a>
    </div>
  </div>
</div>

@endsection

@push('styles')
<style>
.quick-action-link {
  display:flex;align-items:center;gap:14px;padding:16px;border-radius:12px;
  text-decoration:none;transition:all 0.2s;
}
.quick-action-link:hover { transform:translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
</style>
@endpush