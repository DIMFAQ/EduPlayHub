@extends('layouts.buyer')
@section('title', 'Pesanan Berhasil')

@push('styles')
<style>
.wrap{max-width:720px;margin:60px auto;padding:0 24px 80px;text-align:center;position:relative;z-index:1}
.success-card{background:var(--card-bg);border-radius:28px;padding:48px 40px;border:1px solid var(--card-border);box-shadow:var(--shadow);backdrop-filter:blur(20px)}
.check-circle{width:80px;height:80px;border-radius:50%;background:rgba(34,197,94,0.15);border:2px solid rgba(34,197,94,0.35);display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-size:36px;color:#4ade80}
.success-title{font-size:26px;font-weight:700;margin-bottom:8px;letter-spacing:-0.4px;color:var(--text);font-family:'Syne',sans-serif}
.success-sub{font-size:14px;color:var(--muted);margin-bottom:32px;line-height:1.6}
.order-number{display:inline-block;background:rgba(79,70,229,0.14);color:var(--indigo-light);padding:8px 20px;border-radius:40px;font-weight:700;font-size:14px;margin-bottom:28px;letter-spacing:0.5px;border:1px solid rgba(79,70,229,0.22)}
.detail-grid{background:rgba(255,255,255,0.04);border-radius:16px;padding:20px;margin-bottom:28px;text-align:left;border:1px solid var(--card-border)}
.detail-row{display:flex;justify-content:space-between;padding:8px 0;font-size:13px;border-bottom:1px solid var(--card-border);color:var(--text)}
.detail-row:last-child{border-bottom:none;font-weight:700;font-size:15px;color:var(--text);padding-top:14px;margin-top:4px}
.detail-row .label{color:var(--muted)}
.items-list{margin-bottom:20px}
.item-row{display:flex;gap:12px;align-items:center;padding:10px 0;border-bottom:1px solid var(--card-border);text-align:left}
.item-row:last-child{border-bottom:none}
.item-img{width:44px;height:36px;border-radius:8px;overflow:hidden;border:1px solid var(--card-border);flex-shrink:0;background:rgba(255,255,255,0.04)}
.item-img img{width:100%;height:100%;object-fit:cover}
.item-name{flex:1;font-size:13px;font-weight:600;color:var(--text)}
.item-price{font-size:13px;font-weight:700;color:var(--text)}
.action-btns{display:flex;gap:12px;justify-content:center}
.btn-primary{padding:12px 28px;border-radius:40px;background:linear-gradient(135deg,var(--indigo),var(--indigo-dark));color:white;text-decoration:none;font-weight:600;font-size:14px;border:none;cursor:pointer;font-family:inherit;box-shadow:0 8px 24px rgba(79,70,229,0.28)}
.btn-primary:hover{transform:translateY(-2px)}
.btn-secondary{padding:12px 28px;border-radius:40px;background:rgba(255,255,255,0.05);color:var(--text);text-decoration:none;font-weight:600;font-size:14px;border:1px solid var(--card-border)}
.btn-secondary:hover{border-color:var(--indigo);color:var(--indigo-light)}
.status-badge{display:inline-block;padding:4px 14px;border-radius:20px;font-size:11px;font-weight:700;background:rgba(249,115,22,0.12);color:var(--orange-light);margin-left:8px}
</style>
@endpush

@section('content')
<div class="wrap">
  <div class="success-card">
    <div class="check-circle">✓</div>
    <h1 class="success-title">Pesanan Berhasil!</h1>
    <p class="success-sub">
      Terima kasih {{ auth()->user()->name }}! Pesanan Anda telah diterima dan sedang diproses oleh penjual.
    </p>
    <div class="order-number">#{{ $order->order_number }}</div>

    <div class="detail-grid">
      <div class="items-list">
        @foreach($order->items as $item)
        <div class="item-row">
          <div class="item-img">
            <img src="{{ $item->product_image ?? 'https://images.unsplash.com/photo-1517430816045-df4b7de11d1d?auto=format&fit=crop&w=200&q=60' }}" alt="{{ $item->product_name }}">
          </div>
          <div class="item-name">{{ $item->product_name }}@if($item->variant) <span style="color:var(--ink-dim)">· {{ $item->variant }}</span>@endif</div>
          <div class="item-price">×{{ $item->quantity }}</div>
        </div>
        @endforeach
      </div>

      <div class="detail-row">
        <span class="label">Nomor Pesanan</span>
        <span>{{ $order->order_number }}</span>
      </div>
      <div class="detail-row">
        <span class="label">Tipe Transaksi</span>
        <span>{{ $order->type === 'sewa' ? 'Sewa' : 'Beli' }}</span>
      </div>
      @if($order->type === 'sewa' && $order->rental_start)
      <div class="detail-row">
        <span class="label">Durasi Sewa</span>
        <span>{{ $order->rental_start->format('d M Y') }} – {{ $order->rental_end->format('d M Y') }} ({{ $order->rental_days }} hari)</span>
      </div>
      @endif
      <div class="detail-row">
        <span class="label">Metode Pembayaran</span>
        <span>{{ ['transfer'=>'Transfer Bank','cod'=>'Bayar di Tempat','ewallet'=>'E-Wallet'][$order->payment_method] }}</span>
      </div>
      <div class="detail-row">
        <span class="label">Status</span>
        <span>Pesanan Masuk <span class="status-badge">Diproses</span></span>
      </div>
      <div class="detail-row">
        <span class="label">Dikirim ke</span>
        <span>{{ $order->city }}</span>
      </div>
      <div class="detail-row">
        <span class="label">Total Pembayaran</span>
        <span>{{ $order->fmtTotal() }}</span>
      </div>
    </div>

    <div class="action-btns">
      <a href="{{ route('catalog') }}" class="btn-primary">Belanja Lagi</a>
      <a href="{{ route('chat.buyer') }}" class="btn-secondary">Hubungi Penjual</a>
    </div>
  </div>
</div>
@endsection
