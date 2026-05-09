@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

<div class="page-header">
  <h1>
    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
    Profil Saya
  </h1>
  <p>Kelola informasi profil dan keamanan akun Anda</p>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">

  {{-- Informasi Profil --}}
  <div class="card">
    <div class="card-header">
      <div class="card-title">👤 Informasi Profil</div>
    </div>
    <div class="card-body">
      <div style="display:flex;align-items:center;gap:20px;margin-bottom:28px">
        <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,var(--pink-accent),#C2185B);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:26px;box-shadow:0 4px 16px rgba(232,121,160,0.4)">
          {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>
        <div>
          <div style="font-size:18px;font-weight:700;color:var(--text-dark)">{{ $user->name }}</div>
          <div style="font-size:13px;color:var(--text-light)">{{ $user->email }}</div>
          <span class="badge badge-pink" style="margin-top:6px">{{ ucfirst($user->role ?? 'Bidan') }}</span>
        </div>
      </div>

      <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div class="form-full">
          <div class="form-group">
            <label class="form-label">Nama Lengkap <span class="required">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
            @error('name')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-full">
          <div class="form-group">
            <label class="form-label">Email <span class="required">*</span></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
            @error('email')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-green">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>

  {{-- Ubah Password --}}
  <div class="card">
    <div class="card-header">
      <div class="card-title">🔐 Ubah Password</div>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('profile.password') }}">
        @csrf
        @method('PUT')

        <div class="form-full">
          <div class="form-group">
            <label class="form-label">Password Lama <span class="required">*</span></label>
            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
            @error('current_password')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-full">
          <div class="form-group">
            <label class="form-label">Password Baru <span class="required">*</span></label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        </div>

        <div class="form-full">
          <div class="form-group">
            <label class="form-label">Konfirmasi Password Baru <span class="required">*</span></label>
            <input type="password" name="password_confirmation" class="form-control" required>
          </div>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-pink">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            Ubah Password
          </button>
        </div>
      </form>
    </div>
  </div>

</div>

{{-- Info Tambahan --}}
<div class="card" style="margin-top:24px">
  <div class="card-header">
    <div class="card-title">ℹ️ Informasi Akun</div>
  </div>
  <div class="card-body">
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:24px">
      <div class="info-item">
        <div class="info-label">Role</div>
        <div class="info-value">{{ ucfirst($user->role ?? 'Bidan') }}</div>
      </div>
      <div class="info-item">
        <div class="info-label">Terdaftar Sejak</div>
        <div class="info-value">{{ $user->created_at->isoFormat('D MMMM Y') }}</div>
      </div>
      <div class="info-item">
        <div class="info-label">Login Terakhir</div>
        <div class="info-value">{{ now()->isoFormat('D MMMM Y, HH:mm') }}</div>
      </div>
    </div>
  </div>
</div>

@endsection
