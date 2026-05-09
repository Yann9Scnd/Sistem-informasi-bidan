@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')

<div class="page-header">
  <h1>
    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
    Notifikasi
  </h1>
  <p>Pemberitahuan aktivitas terkini di sistem</p>
</div>

@if(count($notifications) > 0)
  <div class="card">
    <div class="card-header">
      <div class="card-title">📬 {{ count($notifications) }} Notifikasi</div>
    </div>
    <div class="card-body" style="padding:0">
      @foreach($notifications as $notif)
        <a href="{{ $notif['link'] }}" class="notif-item" style="text-decoration:none">
          <div class="notif-icon-wrap notif-{{ $notif['type'] }}">
            <span style="font-size:22px">{{ $notif['icon'] }}</span>
          </div>
          <div class="notif-content">
            <div class="notif-title">{{ $notif['title'] }}</div>
            <div class="notif-message">{{ $notif['message'] }}</div>
            <div class="notif-time">{{ $notif['time']->diffForHumans() }}</div>
          </div>
          <svg class="notif-arrow" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
      @endforeach
    </div>
  </div>
@else
  <div class="card">
    <div class="card-body">
      <div class="no-data">
        <svg width="56" height="56" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        <h3>Tidak Ada Notifikasi</h3>
        <p>Semua tugas sudah selesai. Bagus! 🎉</p>
      </div>
    </div>
  </div>
@endif

@endsection
