<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hasil Pemeriksaan — PMB Sri Andayani, Amd.Keb</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/portal.css') }}">
</head>
<body class="hasil-page">

<div class="hasil-container">
  {{-- Header --}}
  <div class="hasil-header">
    <div style="display:flex;align-items:center;gap:12px">
      <div class="portal-logo-sm">🏥</div>
      <div>
        <div style="font-size:16px;font-weight:700;color:white">PMB Sri Andayani, Amd.Keb</div>
        <div style="font-size:11px;color:rgba(255,255,255,0.8)">Portal Pasien</div>
      </div>
    </div>
    <a href="{{ route('portal.lookup') }}" class="btn-back">← Kembali</a>
  </div>

  {{-- Profil Pasien --}}
  <div class="hasil-card">
    <div class="hasil-card-header">
      <div class="hasil-card-title">👤 Data Pasien</div>
    </div>
    <div class="hasil-card-body">
      <div class="detail-grid-portal">
        <div class="detail-item-portal">
          <div class="dl">NIK</div><div class="dv">{{ $pasien->nik }}</div>
        </div>
        <div class="detail-item-portal">
          <div class="dl">Nama</div><div class="dv">{{ $pasien->nama }}</div>
        </div>
        <div class="detail-item-portal">
          <div class="dl">Jenis Kelamin</div><div class="dv">{{ $pasien->jenis_kelamin }}</div>
        </div>
        <div class="detail-item-portal">
          <div class="dl">TTL</div><div class="dv">{{ $pasien->ttl }}</div>
        </div>
        <div class="detail-item-portal">
          <div class="dl">Umur</div><div class="dv">{{ $pasien->umur }}</div>
        </div>
        <div class="detail-item-portal">
          <div class="dl">Poli</div><div class="dv"><span class="badge-portal">{{ $pasien->poli }}</span></div>
        </div>
      </div>
    </div>
  </div>

  {{-- Riwayat Anamnese --}}
  @if($pasien->anamnesa->count())
  <div class="hasil-card">
    <div class="hasil-card-header">
      <div class="hasil-card-title">📋 Anamnese</div>
    </div>
    <div class="hasil-card-body" style="padding:0">
      @foreach($pasien->anamnesa->sortByDesc('created_at') as $a)
      <div class="riwayat-item">
        <div class="riwayat-date">{{ $a->created_at->isoFormat('D MMM Y, HH:mm') }}</div>
        <div class="detail-grid-portal">
          <div class="detail-item-portal"><div class="dl">Petugas</div><div class="dv">{{ $a->nama_petugas }}</div></div>
          <div class="detail-item-portal"><div class="dl">Keluhan</div><div class="dv">{{ $a->keluhan }}</div></div>
          <div class="detail-item-portal"><div class="dl">Riwayat</div><div class="dv">{{ $a->riwayat_pasien ?: '-' }}</div></div>
          <div class="detail-item-portal"><div class="dl">Status Hamil</div><div class="dv">{{ $a->status_hamil ? 'Ya' : 'Tidak' }}</div></div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif

  {{-- Riwayat Pemeriksaan Fisik --}}
  @if($pasien->pemeriksaanFisik->count())
  <div class="hasil-card">
    <div class="hasil-card-header">
      <div class="hasil-card-title">🩺 Pemeriksaan Fisik</div>
    </div>
    <div class="hasil-card-body" style="padding:0">
      @foreach($pasien->pemeriksaanFisik->sortByDesc('created_at') as $pf)
      <div class="riwayat-item">
        <div class="riwayat-date">{{ $pf->created_at->isoFormat('D MMM Y, HH:mm') }}</div>
        <div class="detail-grid-portal">
          <div class="detail-item-portal"><div class="dl">Kesadaran</div><div class="dv">{{ $pf->kesadaran }}</div></div>
          <div class="detail-item-portal"><div class="dl">TD</div><div class="dv">{{ $pf->tekanan_darah }}</div></div>
          <div class="detail-item-portal"><div class="dl">Nadi</div><div class="dv">{{ $pf->nadi }} x/mnt</div></div>
          <div class="detail-item-portal"><div class="dl">Suhu</div><div class="dv">{{ $pf->suhu }} °C</div></div>
          <div class="detail-item-portal"><div class="dl">Nafas (RR)</div><div class="dv">{{ $pf->nafas_rr }} x/mnt</div></div>
          <div class="detail-item-portal"><div class="dl">TB</div><div class="dv">{{ $pf->tinggi_badan }} cm</div></div>
          <div class="detail-item-portal"><div class="dl">BB</div><div class="dv">{{ $pf->berat_badan }} kg</div></div>
          <div class="detail-item-portal"><div class="dl">LILA</div><div class="dv">{{ $pf->lingkar_lengan ? $pf->lingkar_lengan.' cm' : '-' }}</div></div>
          <div class="detail-item-portal"><div class="dl">Lingkar Perut</div><div class="dv">{{ $pf->lingkar_perut ? $pf->lingkar_perut.' cm' : '-' }}</div></div>
          <div class="detail-item-portal"><div class="dl">ANC Terpadu</div><div class="dv">{{ $pf->anc_terpadu }}</div></div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif

  {{-- Riwayat Diagnosis --}}
  @if($pasien->diagnosis->count())
  <div class="hasil-card">
    <div class="hasil-card-header">
      <div class="hasil-card-title">💊 Diagnosis & Resep</div>
    </div>
    <div class="hasil-card-body" style="padding:0">
      @foreach($pasien->diagnosis->sortByDesc('created_at') as $d)
      <div class="riwayat-item">
        <div class="riwayat-date">{{ $d->created_at->isoFormat('D MMM Y, HH:mm') }}</div>
        <div class="detail-grid-portal">
          <div class="detail-item-portal"><div class="dl">Diagnosa</div><div class="dv">{{ $d->diagnosa }}</div></div>
          <div class="detail-item-portal"><div class="dl">Resep Obat</div><div class="dv">{{ $d->resep_obat ?: '-' }}</div></div>
          <div class="detail-item-portal"><div class="dl">Edukasi</div><div class="dv">{{ $d->edukasi ?: '-' }}</div></div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif

  {{-- Download Button --}}
  <div style="text-align:center;margin:28px 0">
    <a href="{{ route('portal.download', ['token' => $token]) }}" class="btn-download">
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
      Download Hasil Pemeriksaan (PDF)
    </a>
  </div>

  <div style="text-align:center;font-size:12px;color:#718096;padding-bottom:24px">
    &copy; {{ date('Y') }} PMB Sri Andayani, Amd.Keb
  </div>
</div>

</body>
</html>
