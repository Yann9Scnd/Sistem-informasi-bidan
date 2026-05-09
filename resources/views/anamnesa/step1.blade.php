@extends('layouts.app')
@section('title', 'Anamnesa - Step 1')
@section('content')

<div class="page-header">
  <h1>📝 Anamnesa — {{ $pasien->nama }}</h1>
  <p>Langkah 1 dari 3: Data anamnesa pasien</p>
</div>

<div class="stepper">
  <div class="step-item"><div class="step-circle active">1</div><span class="step-label active">Anamnesa</span></div>
  <div class="step-line"></div>
  <div class="step-item"><div class="step-circle">2</div><span class="step-label">Pemeriksaan Fisik</span></div>
  <div class="step-line"></div>
  <div class="step-item"><div class="step-circle">3</div><span class="step-label">Diagnosis</span></div>
</div>

<form action="{{ route('anamnesa.step1.store', $pasien) }}" method="POST">
@csrf
<div class="card">
  <div class="card-header"><div class="card-title">🩺 Data Anamnesa</div></div>
  <div class="card-body">

    @if ($errors->any())
      <div class="alert-error">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="2"/><path d="M12 8v4m0 4h.01" stroke-linecap="round" stroke-width="2"/></svg>
        <div><strong>Kesalahan:</strong>
          <ul style="margin-top:4px;padding-left:16px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
      </div>
    @endif

    <div class="section-divider">👩‍⚕️ Petugas Pemeriksa</div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Nama Petugas <span class="required">*</span></label>
        <input type="text" name="nama_petugas" class="form-control @error('nama_petugas') is-invalid @enderror"
          placeholder="Nama bidan/petugas pemeriksa"
          value="{{ old('nama_petugas', $anamnesa->nama_petugas ?? auth()->user()->name) }}" required>
        @error('nama_petugas')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="section-divider" style="margin-top:8px">💬 Keluhan & Riwayat</div>

    <div class="form-full">
      <div class="form-group">
        <label class="form-label">Keluhan <span class="required">*</span></label>
        <textarea name="keluhan" class="form-control @error('keluhan') is-invalid @enderror" rows="3" required
          placeholder="Deskripsikan keluhan pasien">{{ old('keluhan', $anamnesa->keluhan ?? '') }}</textarea>
        @error('keluhan')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="form-full">
      <div class="form-group">
        <label class="form-label">Status Riwayat Pasien</label>
        <textarea name="riwayat_pasien" class="form-control" rows="2"
          placeholder="Riwayat penyakit yang pernah diderita">{{ old('riwayat_pasien', $anamnesa->riwayat_pasien ?? '') }}</textarea>
      </div>
    </div>

    <div class="section-divider" style="margin-top:8px">🤰 Status Kehamilan</div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Apakah pasien sedang hamil? <span class="required">*</span></label>
        <div class="radio-group" style="padding:10px 0">
          <label class="radio-option">
            <input type="radio" name="status_hamil" value="1" {{ old('status_hamil', $anamnesa->status_hamil ?? 0) == 1 ? 'checked' : '' }}>
            Ya, sedang hamil
          </label>
          <label class="radio-option">
            <input type="radio" name="status_hamil" value="0" {{ old('status_hamil', $anamnesa->status_hamil ?? 0) == 0 ? 'checked' : '' }}>
            Tidak
          </label>
        </div>
      </div>
    </div>

    <div class="form-actions">
      <a href="{{ route('pasien.show', $pasien) }}" class="btn btn-gray">← Kembali</a>
      <button type="submit" class="btn btn-green btn-loading-on-submit">
        <span class="btn-text">Simpan & Lanjut →</span>
        <div class="spinner"></div>
      </button>
    </div>
  </div>
</div>
</form>
@endsection
