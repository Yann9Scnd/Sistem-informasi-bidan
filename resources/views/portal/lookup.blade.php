<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cek Hasil Pemeriksaan — PMB Sri Andayani, Amd.Keb</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/portal.css') }}">
</head>
<body>
<div class="portal-card">
  <div class="portal-header">
    <div class="portal-logo">🏥</div>
    <div class="portal-title">PMB Sri Andayani, Amd.Keb</div>
    <div class="portal-subtitle">Portal Pasien — Cek Hasil Pemeriksaan</div>
  </div>
  <div class="portal-body">
    <div class="portal-info">
      <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="flex-shrink:0;margin-top:2px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      <span>Masukkan <strong>NIK</strong> dan <strong>Tanggal Lahir</strong> Anda untuk melihat hasil pemeriksaan.</span>
    </div>
    @if ($errors->any())
      <div class="error-box">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="2"/><path d="M12 8v4m0 4h.01" stroke-width="2" stroke-linecap="round"/></svg>
        <span>{{ $errors->first() }}</span>
      </div>
    @endif
    <form action="{{ route('portal.search') }}" method="POST">
      @csrf
      <div class="form-group">
        <label class="form-label">NIK <span class="req">*</span></label>
        <input type="text" name="nik" class="form-input @error('nik') is-invalid @enderror" placeholder="Masukkan 16 digit NIK" value="{{ old('nik') }}" maxlength="16" inputmode="numeric" required>
      </div>
      <div class="form-group">
        <label class="form-label">Tanggal Lahir <span class="req">*</span></label>
        <input type="date" name="tanggal_lahir" class="form-input @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}" required>
      </div>
      <button type="submit" class="btn-submit">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        Cari Hasil Pemeriksaan
      </button>
    </form>
  </div>
  <div class="portal-footer">
    <p>Halaman ini hanya untuk pasien. <a href="{{ route('login') }}">Login Bidan →</a></p>
  </div>
</div>
</body>
</html>
