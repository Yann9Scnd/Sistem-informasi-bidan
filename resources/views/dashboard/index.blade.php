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

{{-- ===== STAT CARDS ===== --}}
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
    <div class="stat-icon green">👶</div>
    <div>
      <div class="stat-label">Pasien Aktif</div>
      <div class="stat-value">{{ $stats['pasien_aktif'] }}</div>
      <div class="stat-sub">Status aktif</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon blue">📅</div>
    <div>
      <div class="stat-label">Bulan Ini</div>
      <div class="stat-value">{{ $stats['pasien_bulan_ini'] }}</div>
      <div class="stat-sub">Pasien terdaftar</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon orange">🩺</div>
    <div>
      <div class="stat-label">Hari Ini</div>
      <div class="stat-value">{{ $stats['pasien_baru_hari_ini'] }}</div>
      <div class="stat-sub">Pasien baru</div>
    </div>
  </div>
</div>

{{-- ===== CONTENT ROW ===== --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

  {{-- Pasien Terbaru --}}
  <div class="card">
    <div class="card-header">
      <div class="card-title">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        Pasien Terbaru
      </div>
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
          <span class="badge {{ $p->status === 'Aktif' ? 'badge-green' : 'badge-gray' }}">
            {{ $p->status }}
          </span>
        </div>
      @empty
        <div class="no-data" style="padding:40px">
          <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
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
        <a href="{{ route('pasien.create') }}"
           style="display:flex;align-items:center;gap:14px;padding:16px;border-radius:12px;background:var(--pink-secondary);border:1.5px solid var(--pink-primary);text-decoration:none;transition:all 0.2s"
           onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
          <span style="font-size:28px">➕</span>
          <div>
            <div style="font-weight:600;font-size:14px;color:var(--text-dark)">Daftarkan Pasien Baru</div>
            <div style="font-size:12px;color:var(--text-light)">Tambah data pasien ke sistem</div>
          </div>
        </a>
        <a href="{{ route('pasien.index') }}"
           style="display:flex;align-items:center;gap:14px;padding:16px;border-radius:12px;background:#F0FFF4;border:1.5px solid #C6F6D5;text-decoration:none;transition:all 0.2s"
           onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
          <span style="font-size:28px">📋</span>
          <div>
            <div style="font-weight:600;font-size:14px;color:var(--text-dark)">Data Pasien Terdaftar</div>
            <div style="font-size:12px;color:var(--text-light)">Kelola seluruh data pasien</div>
          </div>
        </a>
        <div style="display:flex;align-items:center;gap:14px;padding:16px;border-radius:12px;background:#EBF8FF;border:1.5px solid #BEE3F8;cursor:pointer;transition:all 0.2s"
             onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform=''">
          <span style="font-size:28px">📝</span>
          <div>
            <div style="font-weight:600;font-size:14px;color:var(--text-dark)">Input Anamnesa</div>
            <div style="font-size:12px;color:var(--text-light)">Mulai pemeriksaan pasien</div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

{{-- ===== PELAYANAN ===== --}}
<div class="card" style="margin-top:20px">
  <div class="card-header">
    <div class="card-title">
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
      Jenis Pelayanan
    </div>
  </div>
  <div class="card-body">
    <div class="pelayanan-grid">
      <div class="pelayanan-card" onclick="showToast('Membuka pelayanan ANC...')">
        <div class="pelayanan-icon">🤰</div>
        <div class="pelayanan-title">ANC (Antenatal Care)</div>
        <div class="pelayanan-desc">Pemeriksaan kehamilan rutin</div>
      </div>
      <div class="pelayanan-card" onclick="showToast('Membuka pelayanan KB...')">
        <div class="pelayanan-icon">💊</div>
        <div class="pelayanan-title">Pelayanan KB</div>
        <div class="pelayanan-desc">Keluarga berencana</div>
      </div>
      <div class="pelayanan-card" onclick="showToast('Membuka pelayanan imunisasi...')">
        <div class="pelayanan-icon">💉</div>
        <div class="pelayanan-title">Imunisasi</div>
        <div class="pelayanan-desc">Vaksinasi bayi & balita</div>
      </div>
      <div class="pelayanan-card" onclick="showToast('Membuka pelayanan nifas...')">
        <div class="pelayanan-icon">👶</div>
        <div class="pelayanan-title">Perawatan Nifas</div>
        <div class="pelayanan-desc">Pasca melahirkan</div>
      </div>
      <div class="pelayanan-card" onclick="showToast('Membuka persalinan...')">
        <div class="pelayanan-icon">🏥</div>
        <div class="pelayanan-title">Persalinan</div>
        <div class="pelayanan-desc">Bantuan proses kelahiran</div>
      </div>
      <div class="pelayanan-card" onclick="showToast('Membuka pemeriksaan umum...')">
        <div class="pelayanan-icon">🩺</div>
        <div class="pelayanan-title">Pemeriksaan Umum</div>
        <div class="pelayanan-desc">Konsultasi kesehatan</div>
      </div>
    </div>
  </div>
</div>

@endsection