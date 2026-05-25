@extends('layouts.buyer')
@section('title', 'Hubungi Penjual')

@push('styles')
<style>
.wrap{max-width:900px;margin:0 auto;padding:0 36px 60px;position:relative;z-index:1}
.page-title{font-size:26px;font-weight:700;letter-spacing:-0.4px;margin-bottom:8px;font-family:'Syne',sans-serif;color:var(--text)}
.page-sub{font-size:13px;color:var(--muted);margin-bottom:28px}
.sellers-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px}
.seller-card{background:var(--card-bg);border-radius:20px;padding:22px;border:1px solid var(--card-border);box-shadow:var(--shadow);transition:0.2s;backdrop-filter:blur(20px)}
.seller-card:hover{transform:translateY(-3px);border-color:var(--indigo);box-shadow:0 18px 36px rgba(0,0,0,0.32)}
.seller-avatar{width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;margin-bottom:14px}
.seller-name{font-size:16px;font-weight:700;margin-bottom:4px;color:var(--text)}
.seller-shop{font-size:13px;color:var(--indigo-light);margin-bottom:4px}
.seller-city{font-size:12px;color:var(--muted);margin-bottom:14px;display:flex;align-items:center;gap:4px}
.chat-btn{display:block;width:100%;padding:10px;border-radius:12px;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;text-align:center;text-decoration:none;font-size:13px;font-weight:600;border:none;cursor:pointer;font-family:inherit;box-shadow:0 8px 24px rgba(79,70,229,0.24)}
.chat-btn:hover{transform:translateY(-2px)}
</style>
@endpush

@section('content')
<div class="wrap">
  <h1 class="page-title">Hubungi Penjual</h1>
  <p class="page-sub">Hubungi admin toko untuk pertanyaan produk</p>

  @if($seller)
  <div class="sellers-grid">
    <div class="seller-card">
      <div class="seller-avatar">{{ $seller->initials() }}</div>
      <div class="seller-name">{{ $seller->name }}</div>
      <div class="seller-shop">{{ $seller->shop?->name ?? 'Toko' }}</div>
      <div class="seller-city">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
        {{ $seller->shop?->city ?? 'Indonesia' }}
      </div>
      <a href="{{ route('chat.conversation', $seller) }}" class="chat-btn">Mulai Chat</a>
    </div>
  </div>
  @else
  <div style="text-align:center;padding:60px;color:var(--ink-dim)">
    <p style="font-size:16px;font-weight:600">Admin toko belum tersedia</p>
  </div>
  @endif
</div>
@endsection
