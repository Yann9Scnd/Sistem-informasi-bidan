@extends('layouts.app')

@section('title', 'Data Pasien Baru')

@section('content')

<div class="page-header">
  <h1>
    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
    Data Pasien Baru
  </h1>
  <p>Tambahkan data pasien baru ke sistem klinik</p>
</div>

<form action="{{ route('pasien.store') }}" method="POST" id="pasienForm">
@csrf

{{-- TAB NAVIGATION --}}
<div class="tab-nav">
  <button type="button" class="tab-btn active" onclick="switchTab(this,'tab-data-pasien')">👤 Data Pasien</button>
  <button type="button" class="tab-btn" onclick="switchTab(this,'tab-alamat-tinggal')">🏠 Alamat Tempat Tinggal</button>
  <button type="button" class="tab-btn" onclick="switchTab(this,'tab-alamat-ktp')">📋 Alamat KTP</button>
</div>

{{-- ===== TAB 1: DATA PASIEN ===== --}}
<div id="tab-data-pasien" class="tab-content active">
  <div class="card">
    <div class="card-header">
      <div class="card-title">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        Identitas Pasien
      </div>
    </div>
    <div class="card-body">

      {{-- Validation errors --}}
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
            value="{{ old('nik') }}" required>
          @error('nik')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Nama Lengkap <span class="required">*</span></label>
          <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
            placeholder="Masukkan nama lengkap"
            value="{{ old('nama') }}" required>
          @error('nama')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
      </div>

      <div class="section-divider" style="margin-top:8px">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        Data Pribadi
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Jenis Kelamin <span class="required">*</span></label>
          <div class="radio-group" style="padding:10px 0">
            <label class="radio-option">
              <input type="radio" name="jenis_kelamin" value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'checked' : '' }}>
              Laki-laki
            </label>
            <label class="radio-option">
              <input type="radio" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin', 'Perempuan') === 'Perempuan' ? 'checked' : '' }}>
              Perempuan
            </label>
          </div>
          @error('jenis_kelamin')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
          <label class="form-label">Tanggal Lahir <span class="required">*</span></label>
          <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror"
            value="{{ old('tanggal_lahir') }}" required>
          @error('tanggal_lahir')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Golongan Darah</label>
          <select name="golongan_darah" class="form-control">
            <option value="">-- Pilih --</option>
            @foreach(['A','B','AB','O'] as $gol)
              <option value="{{ $gol }}" {{ old('golongan_darah') === $gol ? 'selected' : '' }}>{{ $gol }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Agama</label>
          <select name="agama" class="form-control">
            <option value="">-- Pilih --</option>
            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $ag)
              <option value="{{ $ag }}" {{ old('agama') === $ag ? 'selected' : '' }}>{{ $ag }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Pekerjaan</label>
          <input type="text" name="pekerjaan" class="form-control"
            placeholder="Pekerjaan pasien" value="{{ old('pekerjaan') }}">
        </div>
        <div class="form-group">
          <label class="form-label">No. HP <span class="required">*</span></label>
          <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
            placeholder="Contoh: 081234567890" value="{{ old('no_hp') }}" required>
          @error('no_hp')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Status Pasien <span class="required">*</span></label>
          <select name="status" class="form-control @error('status') is-invalid @enderror" required>
            <option value="Aktif"      {{ old('status','Aktif') === 'Aktif'       ? 'selected' : '' }}>Aktif</option>
            <option value="Tidak Aktif" {{ old('status') === 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
          </select>
        </div>
      </div>

      <div class="form-actions">
        <a href="{{ route('pasien.index') }}" class="btn btn-gray">
          <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
          Kembali
        </a>
        <button type="button" class="btn btn-pink" onclick="nextTab()">
          Selanjutnya
          <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
      </div>
    </div>
  </div>
</div>

{{-- ===== TAB 2: ALAMAT TINGGAL ===== --}}
<div id="tab-alamat-tinggal" class="tab-content">
  <div class="card">
    <div class="card-header">
      <div class="card-title">🏠 Alamat Tempat Tinggal</div>
    </div>
    <div class="card-body">
      <div class="form-full">
        <div class="form-group">
          <label class="form-label">Alamat Lengkap <span class="required">*</span></label>
          <textarea name="alamat_tinggal" id="alamat_tinggal"
            class="form-control @error('alamat_tinggal') is-invalid @enderror"
            rows="3" placeholder="Jl. Contoh No.1, Kelurahan, Kecamatan"
            required>{{ old('alamat_tinggal') }}</textarea>
          @error('alamat_tinggal')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Kelurahan / Desa</label>
          <input type="text" name="kelurahan" class="form-control" placeholder="Kelurahan" value="{{ old('kelurahan') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Kecamatan</label>
          <input type="text" name="kecamatan" class="form-control" placeholder="Kecamatan" value="{{ old('kecamatan') }}">
        </div>
      </div>
      <div class="form-row-3">
        <div class="form-group">
          <label class="form-label">Kabupaten / Kota</label>
          <input type="text" name="kota" class="form-control" placeholder="Kota/Kabupaten" value="{{ old('kota') }}">
        </div>
        <div class="form-group">
          <label class="form-label">RT</label>
          <input type="text" name="rt" class="form-control" placeholder="RT" value="{{ old('rt') }}">
        </div>
        <div class="form-group">
          <label class="form-label">RW</label>
          <input type="text" name="rw" class="form-control" placeholder="RW" value="{{ old('rw') }}">
        </div>
      </div>
      <div class="form-actions">
        <button type="button" class="btn btn-gray" onclick="prevTab()">
          <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
          Kembali
        </button>
        <button type="button" class="btn btn-pink" onclick="nextTab()">
          Selanjutnya
          <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
      </div>
    </div>
  </div>
</div>

{{-- ===== TAB 3: ALAMAT KTP ===== --}}
<div id="tab-alamat-ktp" class="tab-content">
  <div class="card">
    <div class="card-header">
      <div class="card-title">📋 Alamat Sesuai KTP</div>
    </div>
    <div class="card-body">
      <div style="margin-bottom:16px">
        <label class="checkbox-label" style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:var(--text-medium)">
          <input type="checkbox" style="accent-color:var(--pink-accent)" onclick="copyAlamatKTP(this)">
          Sama dengan alamat tempat tinggal
        </label>
      </div>
      <div class="form-full">
        <div class="form-group">
          <label class="form-label">Alamat KTP</label>
          <textarea name="alamat_ktp" id="alamat_ktp"
            class="form-control"
            rows="3" placeholder="Jl. Contoh No.1, Kelurahan, Kecamatan">{{ old('alamat_ktp') }}</textarea>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label class="form-label">Kelurahan / Desa (KTP)</label>
          <input type="text" class="form-control" placeholder="Kelurahan">
        </div>
        <div class="form-group">
          <label class="form-label">Kecamatan (KTP)</label>
          <input type="text" class="form-control" placeholder="Kecamatan">
        </div>
      </div>
      <div class="form-row-3">
        <div class="form-group">
          <label class="form-label">Kabupaten / Kota</label>
          <input type="text" class="form-control" placeholder="Kota/Kabupaten">
        </div>
        <div class="form-group">
          <label class="form-label">RT</label>
          <input type="text" class="form-control" placeholder="RT">
        </div>
        <div class="form-group">
          <label class="form-label">RW</label>
          <input type="text" class="form-control" placeholder="RW">
        </div>
      </div>
      <div class="form-actions">
        <button type="button" class="btn btn-gray" onclick="prevTab()">
          <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
          Kembali
        </button>
        <button type="submit" class="btn btn-green btn-loading-on-submit" id="submitPasienBtn">
          <span class="btn-text">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan Data Pasien
          </span>
          <div class="spinner"></div>
        </button>
      </div>
    </div>
  </div>
</div>

</form>

@endsection