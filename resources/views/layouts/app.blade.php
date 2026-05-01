<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Dashboard') — PMB Bidan Klinik</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stack('styles')
</head>
<body>

<nav class="navbar">
  <div style="display:flex;align-items:center;gap:12px">
    <button id="menuToggleBtn" style="display:none;background:none;border:none;cursor:pointer;color:#4A5568;padding:4px">
      <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>
    <div class="navbar-brand">
      <div class="nav-logo">🏥</div>
      <div>
        <div class="nav-title">PMB Bidan Klinik</div>
        <div class="nav-subtitle">Sistem Manajemen Pasien</div>
      </div>
    </div>
  </div>
  <div class="navbar-right">
    <button class="notif-btn" title="Notifikasi">
      <div class="notif-badge"></div>
      <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
    </button>
    <div class="user-dropdown">
      <button class="user-avatar" id="avatarBtn">
        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
      </button>
      <div class="dropdown-menu" id="dropdownMenu">
        <div class="dropdown-header">
          <div class="d-name">{{ auth()->user()->name }}</div>
          <div class="d-role">{{ ucfirst(auth()->user()->role ?? 'Bidan') }}</div>
        </div>
        <a href="#" class="dropdown-item">
          <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          Profil Saya
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="dropdown-item danger">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Keluar
          </button>
        </form>
      </div>
    </div>
  </div>
</nav>

<div id="sidebarOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.4);z-index:49"></div>

<div class="app-body">
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-section">
      <div class="sidebar-section-title">Menu Utama</div>
      <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><rect x="3" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="3" width="7" height="7" rx="1" stroke-width="2"/><rect x="3" y="14" width="7" height="7" rx="1" stroke-width="2"/><rect x="14" y="14" width="7" height="7" rx="1" stroke-width="2"/></svg>
        Dashboard
      </a>
    </div>
    <div class="sidebar-section">
      <div class="sidebar-section-title">Data Pasien</div>
      <a href="{{ route('pasien.create') }}" class="nav-item {{ request()->routeIs('pasien.create') ? 'active' : '' }}">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        Data Pasien Baru
        <span class="nav-badge">+</span>
      </a>
      <a href="{{ route('pasien.index') }}" class="nav-item {{ request()->routeIs('pasien.index') ? 'active' : '' }}">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        Data Pasien Terdaftar
      </a>
    </div>
    <div class="sidebar-section">
      <div class="sidebar-section-title">Pelayanan</div>
      <a href="#" class="nav-item">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        Pelayanan
      </a>
      <button class="nav-item {{ request()->routeIs('anamnesa.*') ? 'active' : '' }}" onclick="toggleAnamnesa(this)" type="button">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Anamnesa
        <svg id="anamnesa-arrow" class="chevron" style="margin-left:auto" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
      </button>
      <div class="nav-submenu {{ request()->routeIs('anamnesa.*') ? 'open' : '' }}" id="anamnesa-menu">
        <a href="#" class="nav-subitem"><svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/></svg>Anamnesa</a>
        <a href="#" class="nav-subitem"><svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/></svg>Pemeriksaan Fisik</a>
        <a href="#" class="nav-subitem"><svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/></svg>Lainnya</a>
      </div>
    </div>
    <div class="sidebar-section" style="margin-top:16px">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="nav-item" style="color:#E53E3E">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
          Keluar
        </button>
      </form>
    </div>
  </aside>

  <main class="main-content">
    @yield('content')
  </main>
</div>

<div class="toast-container" id="toastContainer"></div>
@if(session('success'))
  <span id="sessionToast" data-message="{{ session('success') }}" data-type="success" style="display:none"></span>
@elseif(session('error'))
  <span id="sessionToast" data-message="{{ session('error') }}" data-type="error" style="display:none"></span>
@endif

<style>
@media (max-width: 768px) {
  #menuToggleBtn { display: block !important; }
  #sidebarOverlay.show { display: block !important; }
}
</style>

<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>