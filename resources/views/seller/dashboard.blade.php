@extends('layouts.seller')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Penjual')

@push('styles')
<style>
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px}
.stat-card{background:white;border-radius:20px;padding:22px;border:1px solid var(--border-soft);box-shadow:var(--shadow-soft)}
.stat-label{font-size:11px;font-weight:600;color:var(--ink-dim);text-transform:uppercase;letter-spacing:0.5px;margin-bottom:10px}
.stat-value{font-size:28px;font-weight:700;letter-spacing:-0.5px;margin-bottom:4px}
.stat-sub{font-size:11.5px;color:var(--ink-dim)}
.stat-card.accent{background:var(--accent);border-color:var(--accent)}
.stat-card.accent .stat-label,.stat-card.accent .stat-value,.stat-card.accent .stat-sub{color:white}
.stat-card.accent .stat-label{color:rgba(255,255,255,0.7)}
.stat-card.accent .stat-sub{color:rgba(255,255,255,0.65)}
.body-grid{display:grid;grid-template-columns:2fr 1fr;gap:20px}
.card{background:white;border-radius:20px;padding:22px;border:1px solid var(--border-soft);box-shadow:var(--shadow-soft);margin-bottom:20px}
.card-title{font-size:14px;font-weight:700;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between}
.card-title a{font-size:12px;font-weight:500;color:var(--accent);text-decoration:none}
/* Chart */
.chart-wrap{display:flex;align-items:flex-end;gap:10px;height:120px;padding-bottom:4px;border-bottom:1px solid var(--border-soft);margin-bottom:8px}
.bar-group{flex:1;display:flex;flex-direction:column;align-items:center;gap:4px}
.bar{border-radius:8px 8px 0 0;background:var(--accent);min-height:4px;transition:0.3s;width:100%;opacity:0.85}
.bar-label{font-size:10px;color:var(--ink-dim);text-align:center}
.bar-val{font-size:9px;color:var(--ink-mid);text-align:center;font-weight:600}
/* Orders */
.order-row{display:flex;align-items:center;gap:12px;padding:11px 0;border-bottom:1px solid var(--border-soft);font-size:13px}
.order-row:last-child{border-bottom:none}
.status-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0}
.status-dot.masuk{background:#ef4444}
.status-dot.proses{background:#3b82f6}
.status-dot.kirim{background:#0ea5e9}
.status-dot.selesai{background:#22c55e}
.order-name{flex:1;font-weight:600}
.order-total{font-weight:700;font-size:13px}
.order-status{font-size:11px;padding:3px 9px;border-radius:20px;font-weight:600;background:var(--bg)}
/* Products */
.prod-row{display:flex;gap:12px;align-items:center;padding:10px 0;border-bottom:1px solid var(--border-soft)}
.prod-row:last-child{border-bottom:none}
.prod-img{width:44px;height:38px;border-radius:10px;overflow:hidden;border:1px solid var(--border-soft);flex-shrink:0}
.prod-img img{width:100%;height:100%;object-fit:cover}
.prod-name{font-size:13px;font-weight:600;flex:1}
.prod-rented{font-size:11.5px;color:var(--ink-dim)}
/* Customers */
.cust-row{display:flex;align-items:center;gap:10px;padding:9px 0;border-bottom:1px solid var(--border-soft);font-size:13px}
.cust-row:last-child{border-bottom:none}
.cust-av{width:34px;height:34px;border-radius:50%;background:var(--bg);border:1px solid var(--border-soft);display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:600;flex-shrink:0}
.cust-name{font-weight:600;flex:1}
.cust-orders{font-size:11.5px;color:var(--ink-dim)}
</style>
@endpush

@section('content')
<!-- STATS -->
<div class="stats-grid">
  <div class="stat-card accent">
    <div class="stat-label">Total Pendapatan</div>
    <div class="stat-value">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
    <div class="stat-sub">Dari pesanan selesai</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Total Pesanan</div>
    <div class="stat-value">{{ $stats['total_orders'] }}</div>
    <div class="stat-sub">Sepanjang waktu</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Produk Aktif</div>
    <div class="stat-value">{{ $stats['active_products'] }}</div>
    <div class="stat-sub">Sedang dijual</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Rating Rata-rata</div>
    <div class="stat-value">{{ number_format($stats['avg_rating'], 1) }}★</div>
    <div class="stat-sub">Dari semua produk</div>
  </div>
</div>

<div class="body-grid">
  <div>
    <!-- Revenue Chart -->
    <div class="card">
      <div class="card-title">Pendapatan 6 Bulan Terakhir</div>
      @php $maxVal = $months->max('value') ?: 1; @endphp
      <div class="chart-wrap">
        @foreach($months as $m)
        @php $pct = max(4, round(($m['value'] / $maxVal) * 100)); @endphp
        <div class="bar-group">
          <div class="bar-val">{{ $m['value'] > 0 ? 'Rp '.number_format($m['value']/1000000,1).'jt' : '-' }}</div>
          <div class="bar" style="height:{{ $pct }}%"></div>
          <div class="bar-label">{{ $m['label'] }}</div>
        </div>
        @endforeach
      </div>
    </div>

    <!-- Recent Orders -->
    <div class="card">
      <div class="card-title">
        Pesanan Terbaru
        <a href="{{ route('seller.orders') }}">Lihat Semua →</a>
      </div>
      @forelse($recentOrders as $order)
      <div class="order-row">
        <div class="status-dot {{ $order->status }}"></div>
        <div class="order-name">{{ $order->order_number }}</div>
        <div style="font-size:12px;color:var(--ink-mid);flex:1">{{ $order->user->name }}</div>
        <span class="order-status">{{ $order->statusLabel() }}</span>
        <div class="order-total">{{ $order->fmtTotal() }}</div>
      </div>
      @empty
      <p style="text-align:center;color:var(--ink-dim);font-size:13px;padding:20px">Belum ada pesanan</p>
      @endforelse
    </div>
  </div>

  <div>
    <!-- Top Products -->
    <div class="card">
      <div class="card-title">
        Produk Terlaris
        <a href="{{ route('seller.products') }}">Kelola →</a>
      </div>
      @forelse($topProducts as $p)
      <div class="prod-row">
        <div class="prod-img"><img src="{{ $p->mainImage() }}" alt="{{ $p->name }}"></div>
        <div class="prod-name">{{ Str::limit($p->name, 28) }}</div>
        <div class="prod-rented">{{ $p->total_rented }}x</div>
      </div>
      @empty
      <p style="text-align:center;color:var(--ink-dim);font-size:13px;padding:20px">Belum ada produk</p>
      @endforelse
    </div>

    <!-- Recent Customers -->
    <div class="card">
      <div class="card-title">Pelanggan Terkini</div>
      @forelse($recentCustomers as $order)
      <div class="cust-row">
        <div class="cust-av">{{ $order->user->initials() }}</div>
        <div>
          <div class="cust-name">{{ $order->user->name }}</div>
          <div class="cust-orders">{{ $order->created_at->diffForHumans() }}</div>
        </div>
        <a href="{{ route('chat.conversation', $order->user) }}" style="font-size:11px;color:var(--accent);text-decoration:none">Chat</a>
      </div>
      @empty
      <p style="text-align:center;color:var(--ink-dim);font-size:13px;padding:20px">Belum ada pelanggan</p>
      @endforelse
    </div>
  </div>
</div>
@endsection
