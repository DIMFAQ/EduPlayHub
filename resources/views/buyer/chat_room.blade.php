@extends('layouts.buyer')
@section('title', 'Chat - ' . $otherUser->name)

@push('styles')
<style>
.wrap{max-width:900px;margin:0 auto;padding:0 36px 40px;position:relative;z-index:1}
.chat-window{background:var(--card-bg);border-radius:24px;border:1px solid var(--card-border);box-shadow:var(--shadow);display:flex;flex-direction:column;height:calc(100vh - 160px);backdrop-filter:blur(20px)}
.chat-header{display:flex;align-items:center;gap:14px;padding:18px 22px;border-bottom:1px solid var(--card-border);flex-shrink:0}
.avatar{width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:600;flex-shrink:0}
.chat-name{font-weight:600;font-size:16px;color:var(--text)}
.chat-role{font-size:12px;color:var(--muted)}
.back-link{margin-right:auto;text-decoration:none;color:var(--muted);font-size:13px;display:flex;align-items:center;gap:6px}
.back-link:hover{color:var(--indigo-light)}
.messages-area{flex:1;overflow-y:auto;padding:20px 22px;display:flex;flex-direction:column;gap:12px}
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
.chat-input{border-top:1px solid var(--card-border);padding:16px 22px;display:flex;gap:12px;align-items:flex-end;flex-shrink:0}
.input-box{flex:1;border:1px solid var(--card-border);border-radius:20px;padding:11px 18px;font-size:14px;font-family:inherit;color:var(--text);resize:none;max-height:120px;overflow-y:auto;line-height:1.4;background:rgba(255,255,255,0.05)}
.input-box::placeholder{color:var(--muted)}
.input-box:focus{outline:none;border-color:var(--indigo);background:rgba(255,255,255,0.08);box-shadow:0 0 0 3px rgba(79,70,229,0.15)}
.send-btn{width:44px;height:44px;border-radius:50%;border:none;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:0.2s;box-shadow:0 8px 24px rgba(79,70,229,0.28)}
.send-btn:hover{transform:scale(1.05)}
.send-btn svg{width:18px;height:18px}
</style>
@endpush

@section('content')
<div class="wrap">
  <div class="chat-window">
    <div class="chat-header">
      <a href="{{ route('chat.buyer') }}" class="back-link">←</a>
      <div class="avatar">{{ $otherUser->initials() }}</div>
      <div>
        <div class="chat-name">{{ $otherUser->shop?->name ?? $otherUser->name }}</div>
        <div class="chat-role">{{ $otherUser->role === 'seller' ? 'Penjual' : 'Pembeli' }}</div>
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
      <textarea id="msgInput" class="input-box" placeholder="Ketik pesan..." rows="1"
        onkeydown="handleKey(event)"></textarea>
      <button class="send-btn" onclick="sendMsg()">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
        </svg>
      </button>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
const area = document.getElementById('messagesArea');
const sendUrl = "{{ route('chat.send', $otherUser) }}";
const meId = {{ auth()->id() }};
const meInit = "{{ auth()->user()->initials() }}";
const csrf = document.querySelector('meta[name=csrf-token]').content;

area.scrollTop = area.scrollHeight;

function handleKey(e) {
  if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMsg(); }
}

async function sendMsg() {
  const input = document.getElementById('msgInput');
  const body = input.value.trim();
  if (!body) return;
  input.value = '';
  input.style.height = 'auto';

  const res = await fetch(sendUrl, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
    body: JSON.stringify({ body })
  });
  const msg = await res.json();
  appendMsg(msg.body, msg.created_at, true, meInit);
}

function appendMsg(body, time, mine, initials) {
  const row = document.createElement('div');
  row.className = 'msg-row' + (mine ? ' mine' : '');
  row.innerHTML = `<div class="msg-av">${initials}</div><div><div class="bubble">${body}</div><div class="msg-time">${time}</div></div>`;
  area.appendChild(row);
  area.scrollTop = area.scrollHeight;
}

// Poll for new messages every 3s
let lastId = {{ $conversation->messages->last()?->id ?? 0 }};
setInterval(async () => {
  const res = await fetch("{{ route('chat.messages', $otherUser) }}");
  const msgs = await res.json();
  msgs.forEach(m => {
    if (m.id > lastId) {
      lastId = m.id;
      if (!m.mine) appendMsg(m.body, m.created_at, false, m.sender.substring(0,2).toUpperCase());
    }
  });
}, 3000);

// Auto-resize textarea
document.getElementById('msgInput').addEventListener('input', function() {
  this.style.height = 'auto';
  this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});
</script>
@endpush
