@extends('layouts.guest')

@section('title', 'Login')

@push('styles')
<style>
/* ── Login Card ── */
.login-card {
  background: var(--white);
  border-radius: 24px;
  box-shadow: 0 20px 60px rgba(248,200,220,0.4), 0 4px 20px rgba(0,0,0,0.05);
  width: 100%; max-width: 960px;
  display: grid; grid-template-columns: 1fr 1fr;
  overflow: hidden;
  animation: fadeInUp 0.6s ease-out;
  min-height: 580px;
}

/* ── LEFT: FORM SIDE ── */
.form-side {
  padding: 48px 44px;
  display: flex; flex-direction: column; justify-content: center;
}
.brand-logo   { display: flex; align-items: center; gap: 10px; margin-bottom: 32px; }
.logo-icon {
  width: 42px; height: 42px;
  background: linear-gradient(135deg, var(--pink-primary), var(--pink-accent));
  border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  font-size: 20px;
  box-shadow: 0 4px 12px rgba(248,200,220,0.5);
}
.brand-name { font-size: 16px; font-weight: 700; color: var(--text-dark); line-height: 1.2; }
.brand-sub  { font-size: 11px; color: var(--text-light); font-weight: 400; }
.form-title    { font-size: 26px; font-weight: 700; color: var(--text-dark); margin-bottom: 6px; }
.form-subtitle { font-size: 13px; color: var(--text-light); margin-bottom: 32px; font-weight: 400; }

/* ── INPUT GROUP ── */
.input-group  { margin-bottom: 20px; }
.input-label  {
  display: block; font-size: 12px; font-weight: 600;
  color: var(--text-medium); margin-bottom: 8px;
  text-transform: uppercase; letter-spacing: 0.5px;
}
.input-wrapper { position: relative; }
.input-icon {
  position: absolute; left: 14px; top: 50%;
  transform: translateY(-50%);
  color: var(--pink-accent); pointer-events: none;
}
.form-input {
  width: 100%; padding: 13px 16px 13px 44px;
  border: 2px solid #F0E0E8; border-radius: 12px;
  font-family: 'Poppins', sans-serif;
  font-size: 14px; color: var(--text-dark);
  background: #FDFAFC; transition: all 0.25s ease; outline: none;
}
.form-input::placeholder { color: #C0A0B0; }
.form-input:focus {
  border-color: var(--pink-accent); background: var(--white);
  box-shadow: 0 0 0 4px rgba(248,200,220,0.25);
}
.form-input.is-invalid { border-color: var(--error); }

.toggle-password {
  position: absolute; right: 14px; top: 50%;
  transform: translateY(-50%);
  background: none; border: none; cursor: pointer;
  color: var(--gray); padding: 4px; transition: color 0.2s;
}
.toggle-password:hover { color: var(--pink-accent); }

/* ── ERROR BOX ── */
.error-box {
  background: #FFF5F5; border: 1px solid #FEB2B2;
  border-left: 4px solid var(--error);
  border-radius: 10px; padding: 12px 16px;
  font-size: 13px; color: #C53030;
  display: flex; align-items: flex-start; gap: 8px;
  margin-bottom: 20px;
}
.error-field {
  font-size: 12px; color: #C53030;
  margin-top: 5px;
}

/* ── OPTIONS ROW ── */
.form-options {
  display: flex; align-items: center;
  justify-content: space-between; margin-bottom: 24px;
}
.checkbox-label {
  display: flex; align-items: center; gap: 8px;
  cursor: pointer; font-size: 13px; color: var(--text-medium);
}
.checkbox-label input { width: 16px; height: 16px; accent-color: var(--pink-accent); cursor: pointer; }
.forgot-link { font-size: 13px; color: var(--pink-accent); text-decoration: none; font-weight: 500; }
.forgot-link:hover { text-decoration: underline; }

/* ── SUBMIT BUTTON ── */
.btn-login {
  width: 100%; padding: 14px;
  background: var(--green-btn); color: white;
  border: none; border-radius: 12px;
  font-family: 'Poppins', sans-serif;
  font-size: 15px; font-weight: 600;
  cursor: pointer; transition: all 0.25s ease;
  display: flex; align-items: center; justify-content: center; gap: 8px;
  box-shadow: 0 4px 15px rgba(76,175,80,0.35); letter-spacing: 0.3px;
}
.btn-login:hover       { background: var(--green-hover); box-shadow: 0 6px 20px rgba(76,175,80,0.45); transform: translateY(-1px); }
.btn-login:active      { transform: translateY(0); }
.btn-login.loading     { pointer-events: none; opacity: 0.85; }
.btn-login .spinner    { width: 18px; height: 18px; border: 2px solid rgba(255,255,255,0.4); border-top-color: white; border-radius: 50%; animation: spin 0.7s linear infinite; display: none; }
.btn-login.loading .spinner  { display: block; }
.btn-login.loading .btn-text { display: none; }
@keyframes spin { to { transform: rotate(360deg); } }

/* ── RIGHT: ILLUSTRATION ── */
.illustration-side {
  background: linear-gradient(135deg, var(--pink-accent) 0%, #C2185B 100%);
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  padding: 48px 40px; position: relative; overflow: hidden;
}
.illustration-side::before {
  content: ''; position: absolute; top: -60px; right: -60px;
  width: 200px; height: 200px;
  background: rgba(255,255,255,0.15); border-radius: 50%;
}
.illustration-side::after {
  content: ''; position: absolute; bottom: -40px; left: -40px;
  width: 160px; height: 160px;
  background: rgba(255,255,255,0.1); border-radius: 50%;
}
.illustration-svg    { width: 200px; height: 200px; margin-bottom: 28px; position: relative; z-index: 1; filter: drop-shadow(0 8px 24px rgba(0,0,0,0.12)); }
.illustration-title  { font-size: 22px; font-weight: 700; color: white; text-align: center; margin-bottom: 10px; position: relative; z-index: 1; text-shadow: 0 2px 8px rgba(0,0,0,0.1); }
.illustration-desc   { font-size: 13px; color: rgba(255,255,255,0.85); text-align: center; line-height: 1.7; position: relative; z-index: 1; max-width: 240px; }

.floating-badge {
  position: absolute; background: white; border-radius: 12px;
  padding: 10px 14px; font-size: 12px; font-weight: 600;
  color: var(--pink-accent); box-shadow: 0 4px 16px rgba(0,0,0,0.1);
  display: flex; align-items: center; gap: 6px;
  z-index: 2; animation: float 3s ease-in-out infinite;
}
.floating-badge.badge-1 { top: 70px; right: 20px; animation-delay: 0s; }
.floating-badge.badge-2 { bottom: 80px; left: 16px; animation-delay: 1.5s; }
@keyframes float    { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
@keyframes fadeInUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }

@media (max-width: 700px) {
  .login-card          { grid-template-columns: 1fr; }
  .illustration-side   { padding: 36px 32px; order: -1; min-height: 260px; }
  .illustration-svg    { width: 130px; height: 130px; margin-bottom: 16px; }
  .form-side           { padding: 32px 28px; }
  .floating-badge      { display: none; }
}
</style>
@endpush

@section('content')
<div class="login-card">

  {{-- ===== LEFT: FORM ===== --}}
  <div class="form-side">
    <div class="brand-logo">
      <div class="logo-icon">🏥</div>
      <div>
        <div class="brand-name">PMB Bidan Klinik</div>
        <div class="brand-sub">Sistem Manajemen Pasien</div>
      </div>
    </div>

    <h1 class="form-title">Selamat Datang 👋</h1>
    <p class="form-subtitle">Silakan login untuk melanjutkan ke dashboard</p>

    {{-- ERROR BOX --}}
    @if ($errors->any())
      <div class="error-box">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="10" stroke-width="2"/><path d="M12 8v4m0 4h.01" stroke-width="2" stroke-linecap="round"/></svg>
        <span>{{ $errors->first() }}</span>
      </div>
    @endif

    {{-- SESSION SUCCESS (misal setelah logout) --}}
    @if (session('success'))
      <div class="error-box" style="border-left-color:#4CAF50;background:#F0FFF4;color:#276749">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>{{ session('success') }}</span>
      </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST" id="loginForm">
      @csrf

      {{-- EMAIL --}}
      <div class="input-group">
        <label class="input-label" for="email">Email / Username</label>
        <div class="input-wrapper">
          <span class="input-icon">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
          </span>
          <input
            type="email"
            name="email"
            id="email"
            class="form-input @error('email') is-invalid @enderror"
            placeholder="Masukkan email anda"
            value="{{ old('email') }}"
            required
            autocomplete="email"
          >
        </div>
        @error('email')
          <span class="error-field">{{ $message }}</span>
        @enderror
      </div>

      {{-- PASSWORD --}}
      <div class="input-group">
        <label class="input-label" for="passwordInput">Password</label>
        <div class="input-wrapper">
          <span class="input-icon">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
          </span>
          <input
            type="password"
            name="password"
            id="passwordInput"
            class="form-input @error('password') is-invalid @enderror"
            placeholder="Masukkan password"
            required
            autocomplete="current-password"
          >
          <button type="button" class="toggle-password" onclick="togglePassword()" tabindex="-1">
            <svg id="eyeIcon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>
        @error('password')
          <span class="error-field">{{ $message }}</span>
        @enderror
      </div>

      {{-- REMEMBER + FORGOT --}}
      <div class="form-options">
        <label class="checkbox-label">
          <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
          Ingat saya
        </label>
        <a href="#" class="forgot-link">Lupa password?</a>
      </div>

      {{-- SUBMIT --}}
      <button
        type="submit"
        class="btn-login"
        id="loginBtn"
        onclick="this.classList.add('loading')"
      >
        <span class="btn-text">Masuk ke Dashboard</span>
        <div class="spinner"></div>
      </button>
    </form>
  </div>

  {{-- ===== RIGHT: ILLUSTRATION ===== --}}
  <div class="illustration-side">
    <div class="floating-badge badge-1">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      Sistem Terpercaya
    </div>

    {{-- SVG Illustration Bidan (dari HTML asli) --}}
    <svg class="illustration-svg" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="100" cy="100" r="95" fill="rgba(255,255,255,0.2)" stroke="rgba(255,255,255,0.4)" stroke-width="2"/>
      <ellipse cx="100" cy="145" rx="38" ry="30" fill="rgba(255,255,255,0.9)"/>
      <rect x="88" y="130" width="24" height="35" rx="4" fill="rgba(255,255,255,0.7)"/>
      <circle cx="100" cy="80" r="28" fill="#FDDBB5"/>
      <ellipse cx="100" cy="62" rx="28" ry="18" fill="#8B4513"/>
      <ellipse cx="100" cy="68" rx="30" ry="14" fill="#A0522D"/>
      <circle cx="93" cy="80" r="3" fill="#5D4037"/>
      <circle cx="107" cy="80" r="3" fill="#5D4037"/>
      <path d="M93 90 Q100 96 107 90" stroke="#D2691E" stroke-width="2" stroke-linecap="round" fill="none"/>
      <ellipse cx="100" cy="56" rx="26" ry="8" fill="white" opacity="0.95"/>
      <rect x="74" y="49" width="52" height="10" rx="5" fill="white" opacity="0.95"/>
      <rect x="97" y="50" width="6" height="16" rx="1" fill="#F44336"/>
      <rect x="91" y="56" width="18" height="6" rx="1" fill="#F44336"/>
      <path d="M78 118 Q65 125 70 140 Q75 155 85 150" stroke="#607D8B" stroke-width="3" fill="none" stroke-linecap="round"/>
      <circle cx="85" cy="150" r="7" fill="#607D8B"/>
      <circle cx="85" cy="150" r="4" fill="#90A4AE"/>
      <rect x="112" y="120" width="28" height="36" rx="4" fill="white" opacity="0.9"/>
      <rect x="119" y="115" width="14" height="8" rx="3" fill="#E0E0E0"/>
      <line x1="116" y1="130" x2="136" y2="130" stroke="#F8C8DC" stroke-width="2"/>
      <line x1="116" y1="137" x2="136" y2="137" stroke="#F8C8DC" stroke-width="2"/>
      <line x1="116" y1="144" x2="130" y2="144" stroke="#F8C8DC" stroke-width="2"/>
      <path d="M155 35 C155 32 152 29 149 29 C146 29 143 32 143 35 C143 41 149 46 149 46 C149 46 155 41 155 35Z" fill="rgba(255,255,255,0.7)"/>
      <text x="38" y="50" font-size="16" fill="rgba(255,255,255,0.6)">✦</text>
      <text x="155" y="80" font-size="12" fill="rgba(255,255,255,0.5)">✦</text>
      <text x="30" y="155" font-size="10" fill="rgba(255,255,255,0.4)">✦</text>
    </svg>

    <div class="illustration-title">Sistem Klinik Bidan</div>
    <div class="illustration-desc">Membantu pencatatan pasien dengan cepat, akurat, dan efisien untuk pelayanan terbaik</div>

    <div class="floating-badge badge-2">
      <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
      Pelayanan Prima
    </div>
  </div>

</div>

@push('scripts')
<script src="{{ asset('js/app.js') }}"></script>
@endpush
@endsection