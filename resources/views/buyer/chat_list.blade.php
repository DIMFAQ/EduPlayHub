@extends('layouts.buyer')
@section('title', 'Chat')

@push('styles')
<style>
.wrap{max-width:900px;margin:0 auto;padding:0 36px 60px;position:relative;z-index:1}
.page-title{font-size:26px;font-weight:700;letter-spacing:-0.4px;margin-bottom:24px;font-family:'Syne',sans-serif;color:var(--text)}
.chat-list{background:var(--card-bg);border-radius:24px;border:1px solid var(--card-border);box-shadow:var(--shadow);overflow:hidden;backdrop-filter:blur(20px)}
.chat-item{display:flex;gap:14px;align-items:center;padding:18px 22px;border-bottom:1px solid var(--card-border);text-decoration:none;color:inherit;transition:0.15s}
.chat-item:last-child{border-bottom:none}
.chat-item:hover{background:rgba(79,70,229,0.12)}
.avatar{width:46px;height:46px;border-radius:50%;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:600;flex-shrink:0}
.chat-info{flex:1;min-width:0}
.chat-name{font-weight:600;font-size:15px;margin-bottom:3px;color:var(--text)}
.chat-preview{font-size:13px;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.chat-meta{display:flex;flex-direction:column;align-items:flex-end;gap:6px;flex-shrink:0}
.chat-time{font-size:11px;color:var(--muted)}
.unread-badge{background:var(--accent);color:white;border-radius:50%;width:20px;height:20px;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center}
.empty-state{text-align:center;padding:60px;color:var(--muted)}
.new-chat-btn{display:inline-flex;align-items:center;gap:8px;padding:11px 22px;border-radius:40px;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;text-decoration:none;font-size:13.5px;font-weight:600;margin-bottom:20px;box-shadow:0 8px 24px rgba(79,70,229,0.24)}
.new-chat-btn:hover{transform:translateY(-2px)}
</style>
@endpush

@section('content')
<div class="wrap">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px">
    <h1 class="page-title" style="margin-bottom:0">Pesan</h1>
    <a href="{{ route('chat.contact') }}" class="new-chat-btn">+ Chat Baru</a>
  </div>

  @if($conversations->isEmpty())
  <div class="chat-list">
    <div class="empty-state">
      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" style="margin-bottom:16px;opacity:0.3"><path d="M21 15a4 4 0 01-4 4H7l-4 3V7a4 4 0 014-4h10a4 4 0 014 4z"/></svg>
      <p style="font-size:16px;font-weight:600;margin-bottom:8px">Belum ada percakapan</p>
      <p style="font-size:13px;margin-bottom:20px">Mulai chat dengan penjual produk favoritmu</p>
      <a href="{{ route('chat.contact') }}" class="new-chat-btn">Cari Penjual</a>
    </div>
  </div>
  @else
  <div class="chat-list">
    @foreach($conversations as $conv)
    @php $other = $conv->seller; $unread = $conv->unreadCountFor(auth()->id()); @endphp
    <a href="{{ route('chat.conversation', $other) }}" class="chat-item">
      <div class="avatar">{{ $other->initials() }}</div>
      <div class="chat-info">
        <div class="chat-name">{{ $other->shop?->name ?? $other->name }}</div>
        <div class="chat-preview">{{ $conv->lastMessage?->body ?? 'Belum ada pesan' }}</div>
      </div>
      <div class="chat-meta">
        <div class="chat-time">{{ $conv->last_message_at?->diffForHumans() ?? '' }}</div>
        @if($unread > 0)<div class="unread-badge">{{ $unread }}</div>@endif
      </div>
    </a>
    @endforeach
  </div>
  @endif
</div>
@endsection
