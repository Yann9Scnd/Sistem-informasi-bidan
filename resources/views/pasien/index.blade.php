@extends('layouts.app')

@section('title', 'Data Pasien Terdaftar')

@section('content')

<div class="page-header">
  <h1>
    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    Data Pasien Terdaftar
  </h1>
  <p>Kelola data semua pasien yang terdaftar di klinik</p>
</div>

{{-- SEARCH & FILTER --}}
<div class="card" style="margin-bottom:20px">
  <div class="card-body" style="padding:16px 20px">
    <form method="GET" action="{{ route('pasien.index') }}" style="display:flex;gap:12px;align-items:end;flex-wrap:wrap">
      <div style="flex:1;min-width:200px">
        <label class="form-label" style="margin-bottom:4px">Cari Pasien</label>
        <input type="text" name="search" class="form-control search-input"
          placeholder="🔍 Cari nama, NIK, atau no. telp..."
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
      <button type="submit" class="btn btn-pink" style="height:42px">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        Cari
      </button>
      @if(request('search') || request('poli'))
        <a href="{{ route('pasien.index') }}" class="btn btn-gray" style="height:42px">Reset</a>
      @endif
    </form>
  </div>
</div>

{{-- TABLE --}}
<div class="card">
  <div class="card-header">
    <div class="card-title">📋 Daftar Pasien ({{ $pasien->total() }})</div>
    <a href="{{ route('pasien.create') }}" class="btn btn-green" style="font-size:13px">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Tambah Pasien
    </a>
  </div>
  <div class="card-body" style="padding:0;overflow-x:auto">
    <table class="data-table">
      <thead>
        <tr>
          <th>No</th>
          <th>NIK</th>
          <th>Nama</th>
          <th>L/P</th>
          <th>TTL</th>
          <th>No. Telp</th>
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
                <div style="font-size:11px;color:var(--text-light)">{{ $p->umur }}</div>
              </div>
            </div>
          </td>
          <td>
            <span class="badge {{ $p->jenis_kelamin === 'Perempuan' ? 'badge-pink' : 'badge-blue' }}">
              {{ $p->jenis_kelamin === 'Perempuan' ? 'P' : 'L' }}
            </span>
          </td>
          <td style="font-size:12px">{{ $p->ttl }}</td>
          <td style="font-size:12px">{{ $p->no_telp }}</td>
          <td>
            <span class="badge {{ $p->poli === 'KIA' ? 'badge-green' : ($p->poli === 'KB' ? 'badge-purple' : 'badge-orange') }}">
              {{ $p->poli }}
            </span>
          </td>
          <td style="text-align:center">
            <div style="display:flex;gap:6px;justify-content:center;align-items:center">
              <a href="{{ route('pasien.show', $p) }}" class="btn-icon" title="Detail">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              </a>
              <a href="{{ route('pasien.edit', $p) }}" class="btn-icon" title="Edit">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
              </a>
              <button type="button" class="btn-icon danger" title="Hapus"
                onclick="openDeleteModal('{{ $p->nama }}', '{{ route('pasien.destroy', $p) }}')">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
              </button>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8" style="text-align:center;padding:40px;color:var(--text-light)">
            <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="margin:0 auto 12px;display:block;opacity:0.4"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
            Belum ada data pasien. <a href="{{ route('pasien.create') }}" style="color:var(--pink-accent)">Tambah pasien baru</a>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($pasien->hasPages())
  <div class="card-footer">
    {{ $pasien->links() }}
  </div>
  @endif
</div>

{{-- DELETE MODAL --}}
<div class="modal-overlay" id="deleteModal">
  <div class="modal-box">
    <div class="modal-header">
      <h3>🗑️ Hapus Data Pasien</h3>
      <button onclick="closeModal('deleteModal')" class="modal-close">&times;</button>
    </div>
    <div class="modal-body">
      <p>Yakin ingin menghapus data pasien <strong id="deletePatientName"></strong>?</p>
      <p style="font-size:12px;color:var(--text-light)">Data yang sudah dihapus tidak dapat dikembalikan.</p>
    </div>
    <div class="modal-footer">
      <button onclick="closeModal('deleteModal')" class="btn btn-gray">Batal</button>
      <form id="deleteForm" method="POST" style="display:inline">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus</button>
      </form>
    </div>
  </div>
</div>

@endsection