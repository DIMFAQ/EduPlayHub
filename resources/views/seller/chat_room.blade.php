@extends('layouts.seller')
@section('title', 'Chat - ' . $otherUser->name)

@push('styles')
<style>
.page-body{padding:0!important;display:flex;flex-direction:column}
.chat-window{background:var(--card-bg);display:flex;flex-direction:column;height:calc(100vh - 80px);margin:0;border-radius:0;backdrop-filter:blur(20px)}
.chat-header{display:flex;align-items:center;gap:14px;padding:18px 32px;border-bottom:1px solid var(--card-border);flex-shrink:0;background:rgba(13,13,31,0.9)}
.avatar{width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:600;flex-shrink:0}
.chat-name{font-weight:600;font-size:16px;color:var(--text)}
.chat-role{font-size:12px;color:var(--muted)}
.back-link{margin-right:auto;text-decoration:none;color:var(--muted);font-size:13px;display:flex;align-items:center;gap:6px}
.back-link:hover{color:var(--indigo-light)}
.messages-area{flex:1;overflow-y:auto;padding:20px 32px;display:flex;flex-direction:column;gap:12px;background:transparent}
.msg-row{display:flex;gap:10px;max-width:70%;animation:fadeUp 0.2s ease}
@keyframes fadeUp{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:none}}
.msg-row.mine{align-self:flex-end;flex-direction:row-reverse}
.msg-av{width:32px;height:32px;border-radius:50%;background:rgba(255,255,255,0.05);border:1px solid var(--card-border);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:600;color:var(--muted);flex-shrink:0}
.msg-row.mine .msg-av{background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;border-color:transparent}
.bubble{padding:10px 15px;border-radius:18px;font-size:13.5px;line-height:1.5;word-break:break-word}
.msg-row:not(.mine) .bubble{background:rgba(255,255,255,0.05);border:1px solid var(--card-border);border-bottom-left-radius:4px;color:var(--text)}
.msg-row.mine .bubble{background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;border-bottom-right-radius:4px}
.msg-time{font-size:10px;margin-top:4px;text-align:right;opacity:0.6}
.msg-row:not(.mine) .msg-time{text-align:left}
.chat-input{border-top:1px solid var(--card-border);padding:16px 32px;display:flex;gap:12px;align-items:flex-end;flex-shrink:0;background:rgba(13,13,31,0.9)}
.input-box{flex:1;border:1px solid var(--card-border);border-radius:20px;padding:11px 18px;font-size:14px;font-family:inherit;color:var(--text);resize:none;max-height:120px;overflow-y:auto;line-height:1.4;background:rgba(255,255,255,0.05)}
.input-box::placeholder{color:var(--muted)}
.input-box:focus{outline:none;border-color:var(--indigo);background:rgba(255,255,255,0.08);box-shadow:0 0 0 3px rgba(79,70,229,0.15)}
.send-btn{width:44px;height:44px;border-radius:50%;border:none;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:0.2s;box-shadow:0 8px 24px rgba(79,70,229,0.28)}
.send-btn:hover{transform:scale(1.05)}
.send-btn svg{width:18px;height:18px}
</style>
@endpush

@section('content')
<div class="chat-window">
  <div class="chat-header">
    <a href="{{ route('seller.chat') }}" class="back-link">← Kembali</a>
    <div class="avatar">{{ $otherUser->initials() }}</div>
    <div>
      <div class="chat-name">{{ $otherUser->name }}</div>
      <div class="chat-role">Pembeli</div>
    </div>
  </div>

  <div class="messages-area" id="messagesArea">
    @foreach($conversation->messages as $msg)
    @php $mine = $msg->sender_id === auth()->id(); @endphp
    <div class="msg-row {{ $mine ? 'mine' : '' }}">
      <div class="msg-av">{{ $msg->sender->initials() }}</div>
      <div>
        <div class="bubble">{{ $msg->body }}</div>
        <div class="msg-time">{{ $msg->created_at->format('H:i') }}</div>
      </div>
    </div>
    @endforeach
  </div>

  <div class="chat-input">
    <form id="messageForm" style="display:flex;gap:12px;width:100%" onsubmit="sendMessage(event)">
      @csrf
      <textarea class="input-box" id="messageInput" name="body" placeholder="Ketik pesan..." rows="1" required></textarea>
      <button type="submit" class="send-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="22" y1="2" x2="11" y2="13"></line>
          <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
        </svg>
      </button>
    </form>
  </div>
</div>

<script>
const userId = {{ $otherUser->id }};

// Auto-scroll to bottom
function scrollToBottom() {
  const area = document.getElementById('messagesArea');
  area.scrollTop = area.scrollHeight;
}

function sendMessage(e) {
  e.preventDefault();
  const input = document.getElementById('messageInput');
  const body = input.value.trim();
  if (!body) return;

  fetch('{{ route("chat.send", "") }}/' + userId, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({ body })
  })
  .then(r => r.json())
  .then(msg => {
    const html = `
      <div class="msg-row mine">
        <div class="msg-av">{{ auth()->user()->initials() }}</div>
        <div>
          <div class="bubble">${msg.body}</div>
          <div class="msg-time">${msg.created_at}</div>
        </div>
      </div>
    `;
    document.getElementById('messagesArea').innerHTML += html;
    input.value = '';
    scrollToBottom();
  });
}

scrollToBottom();
</script>
@endsection
