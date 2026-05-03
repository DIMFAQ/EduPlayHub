@extends('layouts.seller')
@section('title', 'Pesanan')
@section('page-title', 'Manajemen Pesanan')

@push('styles')
<style>
.filter-bar{display:flex;gap:10px;margin-bottom:24px;flex-wrap:wrap;align-items:center}
.filter-tabs{display:flex;gap:4px;background:white;padding:4px;border-radius:40px;border:1px solid var(--border-soft)}
.tab{padding:7px 16px;border-radius:40px;font-size:12.5px;font-weight:600;color:var(--ink-mid);text-decoration:none;transition:0.18s;border:none;background:none;cursor:pointer;font-family:inherit}
.tab:hover{color:var(--ink)}
.tab.active{background:var(--accent);color:white}
.search-wrap{flex:1;min-width:200px;max-width:340px;position:relative}
.search-wrap svg{position:absolute;left:12px;top:50%;transform:translateY(-50%);width:14px;height:14px;color:var(--ink-dim)}
.search-input{width:100%;padding:9px 14px 9px 36px;border-radius:40px;border:1px solid var(--border-soft);background:white;font-size:13px;font-family:inherit;color:var(--ink)}
.search-input:focus{outline:none;border-color:var(--accent)}
.orders-table{background:white;border-radius:20px;border:1px solid var(--border-soft);box-shadow:var(--shadow-soft);overflow:hidden}
table{width:100%;border-collapse:collapse}
thead{background:var(--bg)}
th{padding:12px 16px;text-align:left;font-size:11px;font-weight:700;color:var(--ink-dim);text-transform:uppercase;letter-spacing:0.5px}
td{padding:14px 16px;font-size:13px;border-top:1px solid var(--border-soft)}
tr:hover td{background:rgba(42,95,196,0.02)}
.status-badge{display:inline-block;padding:4px 11px;border-radius:20px;font-size:11px;font-weight:700}
.status-masuk{background:rgba(239,68,68,0.1);color:#dc2626}
.status-proses{background:rgba(59,130,246,0.1);color:#2563eb}
.status-kirim{background:rgba(14,165,233,0.1);color:#0284c7}
.status-selesai{background:rgba(34,197,94,0.1);color:#16a34a}
.status-dibatalkan{background:rgba(156,163,175,0.1);color:#6b7280}
.order-no{font-weight:700;color:var(--accent)}
.customer-name{font-weight:600}
.total-val{font-weight:700}
.action-btns{display:flex;gap:6px;align-items:center}
.status-select{padding:5px 10px;border-radius:10px;border:1px solid var(--border-soft);background:var(--bg);font-size:12px;font-family:inherit;color:var(--ink);cursor:pointer}
.status-select:focus{outline:none;border-color:var(--accent)}
.empty-row td{text-align:center;padding:60px;color:var(--ink-dim)}
</style>
@endpush

@section('content')
<div class="filter-bar">
  <div class="filter-tabs">
    @foreach(['semua'=>'Semua','masuk'=>'Masuk','proses'=>'Diproses','kirim'=>'Dikirim','selesai'=>'Selesai'] as $val => $label)
    <a href="{{ route('seller.orders', ['status' => $val]) }}" class="tab {{ request('status', 'semua') === $val ? 'active' : '' }}">
      {{ $label }} ({{ $statusCounts[$val] }})
    </a>
    @endforeach
  </div>

  <form method="GET" action="{{ route('seller.orders') }}" class="search-wrap">
    <input type="hidden" name="status" value="{{ request('status','semua') }}">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" name="search" class="search-input" placeholder="Cari no. pesanan / nama..." value="{{ request('search') }}">
  </form>
</div>

<div class="orders-table">
  <table>
    <thead>
      <tr>
        <th>No. Pesanan</th>
        <th>Pelanggan</th>
        <th>Produk</th>
        <th>Total</th>
        <th>Tipe</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($orders as $order)
      <tr>
        <td>
          <div class="order-no">{{ $order->order_number }}</div>
          <div style="font-size:11px;color:var(--ink-dim)">{{ $order->created_at->format('d M Y · H:i') }}</div>
        </td>
        <td>
          <div class="customer-name">{{ $order->user->name }}</div>
          <div style="font-size:11px;color:var(--ink-dim)">{{ $order->city }}</div>
        </td>
        <td>
          <div style="font-size:12px">
            @foreach($order->items->take(2) as $item)
            <div>{{ Str::limit($item->product_name, 30) }} ×{{ $item->quantity }}</div>
            @endforeach
            @if($order->items->count() > 2)
            <div style="color:var(--ink-dim)">+{{ $order->items->count()-2 }} lainnya</div>
            @endif
          </div>
        </td>
        <td><span class="total-val">{{ $order->fmtTotal() }}</span></td>
        <td>
          <span style="font-size:11px;font-weight:600;color:{{ $order->type==='sewa' ? '#4f46e5' : '#16a34a' }}">
            {{ $order->type === 'sewa' ? '📅 Sewa' : '🛒 Beli' }}
          </span>
          @if($order->rental_start)
          <div style="font-size:10px;color:var(--ink-dim)">{{ $order->rental_start->format('d/m') }}–{{ $order->rental_end->format('d/m') }}</div>
          @endif
        </td>
        <td><span class="status-badge status-{{ $order->status }}">{{ $order->statusLabel() }}</span></td>
        <td>
          <div class="action-btns">
            <form method="POST" action="{{ route('seller.orders.status', $order) }}">
              @csrf @method('PATCH')
              <select name="status" class="status-select" onchange="this.form.submit()">
                @foreach(['masuk'=>'Pesanan Masuk','proses'=>'Diproses','kirim'=>'Dikirim','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'] as $v => $l)
                <option value="{{ $v }}" {{ $order->status === $v ? 'selected' : '' }}>{{ $l }}</option>
                @endforeach
              </select>
            </form>
            <a href="{{ route('chat.conversation', $order->user) }}" title="Chat" style="color:var(--accent);text-decoration:none;font-size:16px">💬</a>
          </div>
        </td>
      </tr>
      @empty
      <tr class="empty-row"><td colspan="7">Tidak ada pesanan ditemukan</td></tr>
      @endforelse
    </tbody>
  </table>
</div>

<div style="margin-top:16px">{{ $orders->links() }}</div>
@endsection
