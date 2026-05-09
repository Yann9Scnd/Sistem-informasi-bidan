@extends('layouts.app')
@section('title', 'Diagnosis - Step 3')
@section('content')

<div class="page-header">
  <h1>💊 Diagnosis — {{ $pasien->nama }}</h1>
  <p>Langkah 3 dari 3: Diagnosis, resep obat & edukasi</p>
</div>

<div class="stepper">
  <div class="step-item"><div class="step-circle done">✓</div><span class="step-label done">Anamnesa</span></div>
  <div class="step-line done"></div>
  <div class="step-item"><div class="step-circle done">✓</div><span class="step-label done">Pemeriksaan Fisik</span></div>
  <div class="step-line done"></div>
  <div class="step-item"><div class="step-circle active">3</div><span class="step-label active">Diagnosis</span></div>
</div>

<form action="{{ route('anamnesa.step3.store', $pasien) }}" method="POST">
@csrf
<div class="card">
  <div class="card-header"><div class="card-title">📋 Diagnosis & Resep</div></div>
  <div class="card-body">

    @if ($errors->any())
      <div class="alert-error">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="2"/><path d="M12 8v4m0 4h.01" stroke-linecap="round" stroke-width="2"/></svg>
        <div><strong>Kesalahan:</strong>
          <ul style="margin-top:4px;padding-left:16px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
      </div>
    @endif

    <div class="section-divider">🔍 Diagnosa Sakit</div>

    <div class="form-full">
      <div class="form-group">
        <label class="form-label">Diagnosa <span class="required">*</span></label>
        <textarea name="diagnosa" class="form-control @error('diagnosa') is-invalid @enderror" rows="3" required
          placeholder="Tuliskan diagnosa penyakit pasien">{{ old('diagnosa', $diagnosis->diagnosa ?? '') }}</textarea>
        @error('diagnosa')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="section-divider" style="margin-top:8px">💊 Resep Obat</div>

    <div class="form-full">
      <div class="form-group">
        <label class="form-label">Resep Obat</label>
        <textarea name="resep_obat" class="form-control" rows="3"
          placeholder="Tuliskan resep obat yang diberikan">{{ old('resep_obat', $diagnosis->resep_obat ?? '') }}</textarea>
      </div>
    </div>

    <div class="section-divider" style="margin-top:8px">📖 Edukasi Pasien</div>

    <div class="form-full">
      <div class="form-group">
        <label class="form-label">Edukasi</label>
        <textarea name="edukasi" class="form-control" rows="3"
          placeholder="Tuliskan edukasi/saran untuk pasien">{{ old('edukasi', $diagnosis->edukasi ?? '') }}</textarea>
      </div>
    </div>

    <div class="form-actions">
      <a href="{{ route('anamnesa.step2', $pasien) }}" class="btn btn-gray">← Kembali</a>
      <button type="submit" class="btn btn-green btn-loading-on-submit">
        <span class="btn-text">
          <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
          Simpan & Selesai
        </span>
        <div class="spinner"></div>
      </button>
    </div>
  </div>
</div>
</form>
@endsection
