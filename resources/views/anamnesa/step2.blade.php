@extends('layouts.app')
@section('title', 'Pemeriksaan Fisik - Step 2')
@section('content')

<div class="page-header">
  <h1>📊 Pemeriksaan Fisik — {{ $pasien->nama }}</h1>
  <p>Langkah 2 dari 3: Pemeriksaan fisik pasien</p>
</div>

<div class="stepper">
  <div class="step-item"><div class="step-circle done">✓</div><span class="step-label done">Anamnesa</span></div>
  <div class="step-line done"></div>
  <div class="step-item"><div class="step-circle active">2</div><span class="step-label active">Pemeriksaan Fisik</span></div>
  <div class="step-line"></div>
  <div class="step-item"><div class="step-circle">3</div><span class="step-label">Diagnosis</span></div>
</div>

<form action="{{ route('anamnesa.step2.store', $pasien) }}" method="POST">
@csrf
<div class="card">
  <div class="card-header"><div class="card-title">🏥 Data Pemeriksaan Fisik</div></div>
  <div class="card-body">

    @if ($errors->any())
      <div class="alert-error">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="2"/><path d="M12 8v4m0 4h.01" stroke-linecap="round" stroke-width="2"/></svg>
        <div><strong>Kesalahan:</strong>
          <ul style="margin-top:4px;padding-left:16px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
      </div>
    @endif

    <div class="section-divider">🧠 Kesadaran Pasien</div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Kesadaran <span class="required">*</span></label>
        <select name="kesadaran" class="form-control" required>
          @foreach(['Komposmentis','Somnolen','Sopor','Koma'] as $k)
            <option value="{{ $k }}" {{ old('kesadaran', $pemeriksaan->kesadaran ?? 'Komposmentis') === $k ? 'selected' : '' }}>{{ $k }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="section-divider" style="margin-top:8px">❤️ Tanda Vital</div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">TD Sistolik (mmHg) <span class="required">*</span></label>
        <input type="number" name="td_sistolik" class="form-control @error('td_sistolik') is-invalid @enderror"
          placeholder="120" min="50" max="300" value="{{ old('td_sistolik', $pemeriksaan->td_sistolik ?? '') }}" required>
        @error('td_sistolik')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">TD Diastolik (mmHg) <span class="required">*</span></label>
        <input type="number" name="td_diastolik" class="form-control @error('td_diastolik') is-invalid @enderror"
          placeholder="80" min="30" max="200" value="{{ old('td_diastolik', $pemeriksaan->td_diastolik ?? '') }}" required>
        @error('td_diastolik')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Nadi (N) per menit <span class="required">*</span></label>
        <input type="number" name="nadi" class="form-control @error('nadi') is-invalid @enderror"
          placeholder="80" min="30" max="250" value="{{ old('nadi', $pemeriksaan->nadi ?? '') }}" required>
        @error('nadi')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Suhu (S) °C <span class="required">*</span></label>
        <input type="number" step="0.1" name="suhu" class="form-control @error('suhu') is-invalid @enderror"
          placeholder="36.5" min="30" max="45" value="{{ old('suhu', $pemeriksaan->suhu ?? '') }}" required>
        @error('suhu')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Nafas (RR) per menit <span class="required">*</span></label>
        <input type="number" name="nafas_rr" class="form-control @error('nafas_rr') is-invalid @enderror"
          placeholder="20" min="5" max="60" value="{{ old('nafas_rr', $pemeriksaan->nafas_rr ?? '') }}" required>
        @error('nafas_rr')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="section-divider" style="margin-top:8px">📏 Antropometri</div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Tinggi Badan (TB) cm <span class="required">*</span></label>
        <input type="number" step="0.1" name="tinggi_badan" class="form-control @error('tinggi_badan') is-invalid @enderror"
          placeholder="160" value="{{ old('tinggi_badan', $pemeriksaan->tinggi_badan ?? '') }}" required>
        @error('tinggi_badan')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Berat Badan (BB) kg <span class="required">*</span></label>
        <input type="number" step="0.1" name="berat_badan" class="form-control @error('berat_badan') is-invalid @enderror"
          placeholder="55" value="{{ old('berat_badan', $pemeriksaan->berat_badan ?? '') }}" required>
        @error('berat_badan')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Lingkar Lengan (LILA) cm</label>
        <input type="number" step="0.1" name="lingkar_lengan" class="form-control"
          placeholder="25" value="{{ old('lingkar_lengan', $pemeriksaan->lingkar_lengan ?? '') }}">
      </div>
      <div class="form-group">
        <label class="form-label">Lingkar Perut cm</label>
        <input type="number" step="0.1" name="lingkar_perut" class="form-control"
          placeholder="80" value="{{ old('lingkar_perut', $pemeriksaan->lingkar_perut ?? '') }}">
      </div>
    </div>

    <div class="section-divider" style="margin-top:8px">🏥 ANC Terpadu</div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">ANC Terpadu <span class="required">*</span></label>
        <div class="radio-group" style="padding:10px 0">
          <label class="radio-option">
            <input type="radio" name="anc_terpadu" value="Belum" {{ old('anc_terpadu', $pemeriksaan->anc_terpadu ?? 'Belum') === 'Belum' ? 'checked' : '' }}>
            Belum
          </label>
          <label class="radio-option">
            <input type="radio" name="anc_terpadu" value="Sudah" {{ old('anc_terpadu', $pemeriksaan->anc_terpadu ?? '') === 'Sudah' ? 'checked' : '' }}>
            Sudah
          </label>
        </div>
      </div>
    </div>

    <div class="form-actions">
      <a href="{{ route('anamnesa.step1', $pasien) }}" class="btn btn-gray">← Kembali</a>
      <button type="submit" class="btn btn-green btn-loading-on-submit">
        <span class="btn-text">Simpan & Lanjut →</span>
        <div class="spinner"></div>
      </button>
    </div>
  </div>
</div>
</form>
@endsection
