@extends('layouts.buyer')
@section('title', 'Hubungi Penjual')

@push('styles')
<style>
.wrap{max-width:900px;margin:0 auto;padding:0 36px 60px}
.page-title{font-size:26px;font-weight:700;letter-spacing:-0.4px;margin-bottom:8px}
.page-sub{font-size:13px;color:var(--ink-mid);margin-bottom:28px}
.search-bar{display:flex;gap:0;margin-bottom:28px;background:white;border-radius:40px;border:1px solid var(--border-soft);box-shadow:var(--shadow-soft);overflow:hidden}
.search-bar input{flex:1;padding:14px 20px;border:none;font-size:14px;font-family:inherit;color:var(--ink);background:transparent}
.search-bar input:focus{outline:none}
.sellers-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px}
.seller-card{background:white;border-radius:20px;padding:22px;border:1px solid var(--border-soft);box-shadow:var(--shadow-soft);transition:0.2s}
.seller-card:hover{transform:translateY(-3px);border-color:rgba(42,95,196,0.2);box-shadow:0 12px 32px rgba(13,31,60,0.1)}
.seller-avatar{width:56px;height:56px;border-radius:50%;background:var(--ink);color:white;display:flex;align-items:center;justify-content:center;font-size:18px;font-weight:700;margin-bottom:14px}
.seller-name{font-size:16px;font-weight:700;margin-bottom:4px}
.seller-shop{font-size:13px;color:var(--accent);margin-bottom:4px}
.seller-city{font-size:12px;color:var(--ink-dim);margin-bottom:14px;display:flex;align-items:center;gap:4px}
.chat-btn{display:block;width:100%;padding:10px;border-radius:12px;background:var(--accent);color:white;text-align:center;text-decoration:none;font-size:13px;font-weight:600;border:none;cursor:pointer;font-family:inherit}
.chat-btn:hover{background:var(--accent-hover)}
</style>
@endpush

@section('content')
<div class="wrap">
  <h1 class="page-title">Hubungi Penjual</h1>
  <p class="page-sub">Temukan penjual dan mulai percakapan</p>

  <div class="search-bar">
    <input type="text" id="searchInput" placeholder="Cari nama penjual atau toko..." oninput="filterSellers()">
  </div>

  <div class="sellers-grid" id="sellerGrid">
    @foreach($sellers as $seller)
    <div class="seller-card" data-name="{{ strtolower($seller->name) }} {{ strtolower($seller->shop?->name ?? '') }}">
      <div class="seller-avatar">{{ $seller->initials() }}</div>
      <div class="seller-name">{{ $seller->name }}</div>
      <div class="seller-shop">{{ $seller->shop?->name ?? 'Toko' }}</div>
      <div class="seller-city">
        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
        {{ $seller->shop?->city ?? 'Indonesia' }}
      </div>
      <a href="{{ route('chat.conversation', $seller) }}" class="chat-btn">💬 Mulai Chat</a>
    </div>
    @endforeach
  </div>

  @if($sellers->isEmpty())
  <div style="text-align:center;padding:60px;color:var(--ink-dim)">
    <p style="font-size:16px;font-weight:600">Belum ada penjual terdaftar</p>
  </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
function filterSellers() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  document.querySelectorAll('.seller-card').forEach(c => {
    c.style.display = c.dataset.name.includes(q) ? '' : 'none';
  });
}
</script>
@endpush
