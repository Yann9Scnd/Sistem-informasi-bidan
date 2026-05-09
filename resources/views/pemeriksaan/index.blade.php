@extends('layouts.app')
@section('title', 'Data Pemeriksaan')
@section('content')

<div class="page-header">
  <h1>📊 Data Pemeriksaan</h1>
  <p>Daftar semua pemeriksaan fisik pasien</p>
</div>

<div class="card" style="margin-bottom:20px">
  <div class="card-body" style="padding:16px 20px">
    <form method="GET" action="{{ route('pemeriksaan.index') }}" style="display:flex;gap:12px;align-items:end;flex-wrap:wrap">
      <div style="flex:1;min-width:200px">
        <label class="form-label" style="margin-bottom:4px">Cari</label>
        <input type="text" name="search" class="form-control search-input" placeholder="🔍 Cari nama atau NIK pasien..." value="{{ request('search') }}">
      </div>
      <button type="submit" class="btn btn-pink" style="height:42px">Cari</button>
      @if(request('search'))
        <a href="{{ route('pemeriksaan.index') }}" class="btn btn-gray" style="height:42px">Reset</a>
      @endif
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">📋 Riwayat Pemeriksaan ({{ $pemeriksaan->total() }})</div>
  </div>
  <div class="card-body" style="padding:0;overflow-x:auto">
    <table class="data-table">
      <thead>
        <tr>
          <th>No</th>
          <th>Tanggal</th>
          <th>Pasien</th>
          <th>Kesadaran</th>
          <th>TD</th>
          <th>Nadi</th>
          <th>Suhu</th>
          <th>RR</th>
          <th>BB</th>
          <th>ANC</th>
          <th style="text-align:center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pemeriksaan as $i => $pf)
        <tr>
          <td>{{ $pemeriksaan->firstItem() + $i }}</td>
          <td style="font-size:12px;white-space:nowrap">{{ $pf->created_at->format('d/m/Y H:i') }}</td>
          <td>
            <div style="font-weight:600;color:var(--text-dark)">{{ $pf->pasien->nama ?? '-' }}</div>
            <div style="font-size:11px;color:var(--text-light)">{{ $pf->pasien->nik ?? '-' }}</div>
          </td>
          <td>{{ $pf->kesadaran }}</td>
          <td>{{ $pf->tekanan_darah }}</td>
          <td>{{ $pf->nadi }}</td>
          <td>{{ $pf->suhu }}°C</td>
          <td>{{ $pf->nafas_rr }}</td>
          <td>{{ $pf->berat_badan }} kg</td>
          <td><span class="badge {{ $pf->anc_terpadu === 'Sudah' ? 'badge-green' : 'badge-gray' }}">{{ $pf->anc_terpadu }}</span></td>
          <td style="text-align:center">
            <a href="{{ route('pemeriksaan.show', $pf) }}" class="btn-icon" title="Detail">
              <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="11" style="text-align:center;padding:40px;color:var(--text-light)">Belum ada data pemeriksaan.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if($pemeriksaan->hasPages())
  <div class="card-footer">{{ $pemeriksaan->links() }}</div>
  @endif
</div>

@endsection
