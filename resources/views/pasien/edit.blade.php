@extends('layouts.app')

@section('title', 'Edit Pasien')

@section('content')

<div class="page-header">
  <h1>
    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
    Edit Data Pasien
  </h1>
  <p>Perbarui data pasien: {{ $pasien->nama }}</p>
</div>

<form action="{{ route('pasien.update', $pasien) }}" method="POST">
@csrf
@method('PUT')

<div class="card">
  <div class="card-header">
    <div class="card-title">
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
      Data Pendaftaran Pasien
    </div>
  </div>
  <div class="card-body">

    @if ($errors->any())
      <div class="alert-error">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="2"/><path d="M12 8v4m0 4h.01" stroke-linecap="round" stroke-width="2"/></svg>
        <div>
          <strong>Terdapat kesalahan input:</strong>
          <ul style="margin-top:4px;padding-left:16px">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    @endif

    <div class="section-divider">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/></svg>
      Kartu Identitas
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">NIK <span class="required">*</span></label>
        <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
          placeholder="Masukkan NIK (16 digit)" maxlength="16"
          value="{{ old('nik', $pasien->nik) }}" required>
        @error('nik')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">No. Urut Pendaftaran</label>
        <input type="text" class="form-control" value="{{ str_pad($pasien->no_urut, 3, '0', STR_PAD_LEFT) }}" readonly
          style="background:#f0f0f0;font-weight:600;color:var(--pink-accent)">
      </div>
    </div>

    <div class="section-divider" style="margin-top:8px">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
      Data Pribadi
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Nama Lengkap <span class="required">*</span></label>
        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
          placeholder="Masukkan nama lengkap"
          value="{{ old('nama', $pasien->nama) }}" required>
        @error('nama')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Jenis Kelamin <span class="required">*</span></label>
        <div class="radio-group" style="padding:10px 0">
          <label class="radio-option">
            <input type="radio" name="jenis_kelamin" value="Laki-laki" {{ old('jenis_kelamin', $pasien->jenis_kelamin) === 'Laki-laki' ? 'checked' : '' }}>
            Laki-laki
          </label>
          <label class="radio-option">
            <input type="radio" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin', $pasien->jenis_kelamin) === 'Perempuan' ? 'checked' : '' }}>
            Perempuan
          </label>
        </div>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" class="form-control"
          placeholder="Kota/Kabupaten" value="{{ old('tempat_lahir', $pasien->tempat_lahir) }}">
      </div>
      <div class="form-group">
        <label class="form-label">Tanggal Lahir <span class="required">*</span></label>
        <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror"
          value="{{ old('tanggal_lahir', $pasien->tanggal_lahir?->format('Y-m-d')) }}" required>
        @error('tanggal_lahir')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="form-full">
      <div class="form-group">
        <label class="form-label">Alamat Lengkap <span class="required">*</span></label>
        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
          rows="3" placeholder="Jl. Contoh No.1, RT/RW, Kelurahan, Kecamatan, Kota"
          required>{{ old('alamat', $pasien->alamat) }}</textarea>
        @error('alamat')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Nama Orang Tua Kandung</label>
        <input type="text" name="nama_ortu" class="form-control"
          placeholder="Nama ayah/ibu kandung" value="{{ old('nama_ortu', $pasien->nama_ortu) }}">
      </div>
      <div class="form-group">
        <label class="form-label">No. Telepon <span class="required">*</span></label>
        <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror"
          placeholder="Contoh: 081234567890" value="{{ old('no_telp', $pasien->no_telp) }}" required>
        @error('no_telp')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="section-divider" style="margin-top:8px">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
      Poli Tujuan
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Poli <span class="required">*</span></label>
        <select name="poli" class="form-control @error('poli') is-invalid @enderror" required>
          <option value="">-- Pilih Poli --</option>
          <option value="KIA" {{ old('poli', $pasien->poli) === 'KIA' ? 'selected' : '' }}>KIA (Kesehatan Ibu & Anak)</option>
          <option value="KB" {{ old('poli', $pasien->poli) === 'KB' ? 'selected' : '' }}>KB (Keluarga Berencana)</option>
          <option value="MTBS" {{ old('poli', $pasien->poli) === 'MTBS' ? 'selected' : '' }}>MTBS (Balita Sakit 0-6 th)</option>
        </select>
        @error('poli')<span class="invalid-feedback">{{ $message }}</span>@enderror
      </div>
    </div>

    <div class="form-actions">
      <a href="{{ route('pasien.index') }}" class="btn btn-gray">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
      </a>
      <button type="submit" class="btn btn-green btn-loading-on-submit">
        <span class="btn-text">
          <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
          Simpan Perubahan
        </span>
        <div class="spinner"></div>
      </button>
    </div>
  </div>
</div>

</form>

@endsection
