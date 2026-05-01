@extends('layouts.app')

@section('title', 'Data Pasien Terdaftar')

@section('content')

<div class="page-header">
  <h1>
    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
    Data Pasien Terdaftar
  </h1>
  <p>Kelola seluruh data pasien yang terdaftar di klinik</p>
</div>

<div class="card">
  <div class="card-header">
    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('pasien.index') }}" style="display:contents">
      <div class="table-toolbar">
        <div class="search-input-wrap">
          <span class="search-icon">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="11" cy="11" r="8" stroke-width="2"/><path d="m21 21-4.35-4.35" stroke-width="2" stroke-linecap="round"/></svg>
          </span>
          <input
            type="text"
            name="search"
            class="search-input"
            placeholder="Cari nama, NIK, atau No HP..."
            value="{{ request('search') }}"
          >
        </div>

        <select name="status" class="filter-select" onchange="this.form.submit()">
          <option value="">Semua Status</option>
          <option value="Aktif"      {{ request('status') === 'Aktif'       ? 'selected' : '' }}>Aktif</option>
          <option value="Tidak Aktif" {{ request('status') === 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
        </select>

        <button type="submit" class="btn btn-pink btn-sm">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="11" cy="11" r="8" stroke-width="2"/><path d="m21 21-4.35-4.35" stroke-width="2" stroke-linecap="round"/></svg>
          Cari
        </button>

        @if(request()->hasAny(['search','status']))
          <a href="{{ route('pasien.index') }}" class="btn btn-gray btn-sm">Reset</a>
        @endif
      </div>
    </form>

    <a href="{{ route('pasien.create') }}" class="btn btn-pink btn-sm">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Tambah Pasien
    </a>
  </div>

  {{-- TABLE --}}
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>NIK</th>
          <th>Nama Pasien</th>
          <th>Jenis Kelamin</th>
          <th>Tanggal Lahir</th>
          <th>Umur</th>
          <th>No HP</th>
          <th>Alamat</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pasien as $p)
          <tr>
            <td><strong>{{ $loop->iteration + ($pasien->currentPage() - 1) * $pasien->perPage() }}</strong></td>
            <td><span style="font-family:monospace;font-size:12px">{{ $p->nik }}</span></td>
            <td><strong style="color:var(--text-dark)">{{ $p->nama }}</strong></td>
            <td><span class="badge badge-pink">{{ $p->jenis_kelamin }}</span></td>
            <td>{{ $p->tanggal_lahir_format }}</td>
            <td>{{ $p->umur }}</td>
            <td>{{ $p->no_hp }}</td>
            <td style="max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:12px">
              {{ $p->alamat_tinggal }}
            </td>
            <td>
              <span class="badge {{ $p->status === 'Aktif' ? 'badge-green' : 'badge-gray' }}">
                {{ $p->status === 'Aktif' ? '● Aktif' : '○ Tidak Aktif' }}
              </span>
            </td>
            <td>
              <div class="action-btns">
                {{-- Detail --}}
                <a href="{{ route('pasien.show', $p) }}" class="btn btn-sm btn-blue-soft" title="Detail">
                  <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </a>
                {{-- Edit --}}
                <a href="{{ route('pasien.edit', $p) }}" class="btn btn-sm btn-yellow-soft" title="Edit">
                  <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                {{-- Hapus --}}
                <button
                  class="btn btn-sm btn-red-soft"
                  title="Hapus"
                  onclick="openDeleteModal('{{ addslashes($p->nama) }}', '{{ route('pasien.destroy', $p) }}')"
                >
                  <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="10">
              <div class="no-data">
                <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <h3>Tidak ada data pasien</h3>
                <p>Belum ada pasien yang terdaftar atau tidak ditemukan hasil pencarian</p>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- PAGINATION --}}
  <div class="pagination">
    <div class="pagination-info">
      Menampilkan <strong>{{ $pasien->firstItem() ?? 0 }}–{{ $pasien->lastItem() ?? 0 }}</strong>
      dari <strong>{{ $pasien->total() }}</strong> pasien
    </div>
    <div class="pagination-btns">
      @if($pasien->onFirstPage())
        <button class="pg-btn" disabled>‹</button>
      @else
        <a href="{{ $pasien->previousPageUrl() }}" class="pg-btn">‹</a>
      @endif

      @foreach($pasien->getUrlRange(1, $pasien->lastPage()) as $page => $url)
        <a href="{{ $url }}" class="pg-btn {{ $page == $pasien->currentPage() ? 'active' : '' }}">{{ $page }}</a>
      @endforeach

      @if($pasien->hasMorePages())
        <a href="{{ $pasien->nextPageUrl() }}" class="pg-btn">›</a>
      @else
        <button class="pg-btn" disabled>›</button>
      @endif
    </div>
  </div>

</div>

{{-- ===== MODAL HAPUS ===== --}}
<div class="modal-overlay" id="deleteModal">
  <div class="modal">
    <div class="modal-icon">🗑️</div>
    <div class="modal-title">Hapus Data Pasien?</div>
    <div class="modal-body">
      Data pasien <strong id="deletePatientName"></strong> akan dihapus secara permanen.
      Tindakan ini tidak dapat dibatalkan.
    </div>
    <div class="modal-actions">
      <button class="btn btn-gray" onclick="closeModal('deleteModal')">Batal</button>
      <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-red btn-loading-on-submit">
          <span class="btn-text">Ya, Hapus</span>
          <div class="spinner"></div>
        </button>
      </form>
    </div>
  </div>
</div>

@endsection