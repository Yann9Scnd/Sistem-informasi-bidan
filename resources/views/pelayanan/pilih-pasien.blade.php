@extends('layouts.app')
@section('title', 'Pilih Pasien - Pelayanan')
@section('content')

<div class="page-header">
  <h1>🩺 Pelayanan — Pilih Pasien</h1>
  <p>Pilih pasien yang akan diperiksa untuk memulai anamnese, pemeriksaan fisik, dan diagnosis</p>
</div>

{{-- SEARCH & FILTER --}}
<div class="card" style="margin-bottom:20px">
  <div class="card-body" style="padding:16px 20px">
    <form method="GET" action="{{ route('pelayanan.pilih-pasien') }}" style="display:flex;gap:12px;align-items:end;flex-wrap:wrap">
      <div style="flex:1;min-width:200px">
        <label class="form-label" style="margin-bottom:4px">Cari Pasien</label>
        <input type="text" name="search" class="form-control search-input"
          placeholder="🔍 Cari nama atau NIK..."
          value="{{ request('search') }}">
      </div>
      <div style="min-width:140px">
        <label class="form-label" style="margin-bottom:4px">Poli</label>
        <select name="poli" class="form-control">
          <option value="">Semua Poli</option>
          <option value="KIA" {{ request('poli') === 'KIA' ? 'selected' : '' }}>KIA</option>
          <option value="KB" {{ request('poli') === 'KB' ? 'selected' : '' }}>KB</option>
          <option value="MTBS" {{ request('poli') === 'MTBS' ? 'selected' : '' }}>MTBS</option>
        </select>
      </div>
      <button type="submit" class="btn btn-pink" style="height:42px">Cari</button>
      @if(request('search') || request('poli'))
        <a href="{{ route('pelayanan.pilih-pasien') }}" class="btn btn-gray" style="height:42px">Reset</a>
      @endif
    </form>
  </div>
</div>

{{-- PATIENT TABLE --}}
<div class="card">
  <div class="card-header">
    <div class="card-title">📋 Pilih Pasien untuk Pemeriksaan ({{ $pasien->total() }})</div>
  </div>
  <div class="card-body" style="padding:0;overflow-x:auto">
    <table class="data-table">
      <thead>
        <tr>
          <th>No</th>
          <th>NIK</th>
          <th>Nama</th>
          <th>L/P</th>
          <th>Umur</th>
          <th>Poli</th>
          <th style="text-align:center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pasien as $i => $p)
        <tr>
          <td>{{ $pasien->firstItem() + $i }}</td>
          <td style="font-family:monospace;font-size:12px">{{ $p->nik }}</td>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              <div class="avatar-sm">{{ $p->inisial }}</div>
              <div>
                <div style="font-weight:600;color:var(--text-dark)">{{ $p->nama }}</div>
                <div style="font-size:11px;color:var(--text-light)">{{ $p->ttl }}</div>
              </div>
            </div>
          </td>
          <td>
            <span class="badge {{ $p->jenis_kelamin === 'Perempuan' ? 'badge-pink' : 'badge-blue' }}">
              {{ $p->jenis_kelamin === 'Perempuan' ? 'P' : 'L' }}
            </span>
          </td>
          <td>{{ $p->umur }}</td>
          <td>
            <span class="badge {{ $p->poli === 'KIA' ? 'badge-green' : ($p->poli === 'KB' ? 'badge-purple' : 'badge-orange') }}">
              {{ $p->poli }}
            </span>
          </td>
          <td style="text-align:center">
            <a href="{{ route('anamnesa.step1', $p) }}" class="btn btn-green btn-sm" style="font-size:12px;padding:6px 14px">
              🩺 Mulai Pemeriksaan
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="text-align:center;padding:40px;color:var(--text-light)">
            Belum ada pasien terdaftar. <a href="{{ route('pasien.create') }}" style="color:var(--pink-accent)">Daftarkan pasien baru</a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($pasien->hasPages())
  <div class="card-footer">{{ $pasien->links() }}</div>
  @endif
</div>

@endsection
