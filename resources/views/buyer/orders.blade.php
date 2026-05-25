@extends('layouts.buyer')

@section('content')
<style>
  .orders-container {
    position: relative; z-index: 1;
    max-width: 1200px; margin: 0 auto;
    padding: 2rem;
  }

  .page-header {
    margin-bottom: 2rem;
  }

  .page-title {
    font-family: 'Syne', sans-serif;
    font-size: 2rem; font-weight: 700;
    color: var(--text);
    margin-bottom: 0.5rem;
  }

  .page-subtitle {
    color: var(--muted); font-size: 0.95rem;
  }

  /* ── FILTERS ── */
  .filters-row {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr auto;
    gap: 1rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    backdrop-filter: blur(20px);
  }

  .filter-group {
    display: flex; flex-direction: column;
  }

  .filter-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--muted);
    margin-bottom: 0.5rem;
    font-weight: 600;
  }

  .filter-select,
  .filter-input {
    padding: 0.75rem 1rem;
    background: rgba(255,255,255,0.05);
    border: 1px solid var(--card-border);
    border-radius: 10px;
    color: var(--text);
    font-family: inherit;
    font-size: 0.9rem;
    transition: 0.2s;
  }

  .filter-select:focus,
  .filter-input:focus {
    outline: none;
    border-color: var(--indigo);
    background: rgba(255,255,255,0.08);
    box-shadow: 0 0 0 3px rgba(79,70,229,0.2);
  }

  .filter-btn {
    align-self: flex-end;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, var(--indigo), var(--indigo-dark));
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
  }

  .filter-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 24px rgba(79,70,229,0.3);
  }

  /* ── STATUS CHIPS ── */
  .status-chips {
    display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap;
  }

  .chip {
    padding: 0.5rem 1.2rem;
    border-radius: 100px;
    font-size: 0.85rem; font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
    border: 1px solid var(--card-border);
    background: rgba(255,255,255,0.04);
    color: var(--muted);
  }

  .chip:hover {
    border-color: var(--indigo);
    background: rgba(79,70,229,0.1);
    color: var(--indigo-light);
  }

  .chip.active {
    background: linear-gradient(135deg, var(--indigo), var(--indigo-dark));
    color: white;
    border-color: var(--indigo);
  }

  /* ── ORDERS LIST ── */
  .orders-list {
    display: flex; flex-direction: column; gap: 1.5rem;
  }

  .order-card {
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    padding: 1.5rem;
    transition: 0.2s;
    cursor: pointer;
    backdrop-filter: blur(20px);
  }

  .order-card:hover {
    border-color: var(--indigo);
    background: rgba(79,70,229,0.08);
  }

  .order-header {
    display: flex; justify-content: space-between; align-items: start;
    margin-bottom: 1rem;
    gap: 1rem;
  }

  .order-id {
    display: flex; flex-direction: column;
  }

  .order-number {
    font-family: 'Syne', sans-serif;
    font-size: 1.1rem; font-weight: 700;
    color: var(--text);
  }

  .order-code {
    font-size: 0.8rem; color: var(--muted);
    margin-top: 0.25rem;
  }

  .order-badges {
    display: flex; gap: 0.75rem; flex-wrap: wrap;
  }

  .badge {
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .badge-type-beli { background: rgba(14,165,233,0.15); color: var(--sky-light); }
  .badge-type-sewa { background: rgba(249,115,22,0.15); color: var(--orange-light); }

  .badge-status-pending { background: rgba(249,115,22,0.15); color: var(--orange-light); }
  .badge-status-masuk { background: rgba(79,70,229,0.15); color: var(--indigo-light); }
  .badge-status-proses { background: rgba(14,165,233,0.15); color: var(--sky-light); }
  .badge-status-kirim { background: rgba(129,140,248,0.15); color: var(--indigo-light); }
  .badge-status-selesai { background: rgba(34,197,94,0.15); color: #4ade80; }
  .badge-paid { background: rgba(34,197,94,0.15); color: #4ade80; }
  .badge-unpaid { background: rgba(239,68,68,0.15); color: #fca5a5; }

  .order-items {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;
    margin: 1rem 0;
    padding: 1rem 0;
    border-top: 1px solid var(--card-border);
    border-bottom: 1px solid var(--card-border);
  }

  .item-preview {
    display: flex; gap: 1rem;
  }

  .item-image {
    width: 60px; height: 60px;
    border-radius: 8px;
    background: rgba(255,255,255,0.05);
    border: 1px solid var(--card-border);
    overflow: hidden;
    flex-shrink: 0;
  }

  .item-image img {
    width: 100%; height: 100%; object-fit: cover;
  }

  .item-info {
    flex: 1;
  }

  .item-name {
    font-size: 0.9rem; font-weight: 600;
    color: var(--text);
    margin-bottom: 0.25rem;
    line-height: 1.3;
  }

  .item-qty {
    font-size: 0.8rem; color: var(--muted);
  }

  .order-footer {
    display: flex; justify-content: space-between; align-items: center;
  }

  .order-meta {
    display: flex; gap: 2rem;
  }

  .meta-item {
    display: flex; flex-direction: column;
  }

  .meta-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--muted);
    margin-bottom: 0.25rem;
  }

  .meta-value {
    font-size: 0.95rem; font-weight: 600;
    color: var(--text);
  }

  .order-action {
    padding: 0.6rem 1.2rem;
    background: linear-gradient(135deg, var(--indigo), var(--indigo-dark));
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
  }

  .order-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(79,70,229,0.3);
  }

  /* ── EMPTY STATE ── */
  .empty-state {
    text-align: center;
    padding: 3rem 2rem;
    background: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 16px;
    backdrop-filter: blur(20px);
  }

  .empty-icon {
    font-size: 3rem; margin-bottom: 1rem;
  }

  .empty-title {
    font-size: 1.2rem; font-weight: 700;
    color: var(--text);
    margin-bottom: 0.5rem;
  }

  .empty-text {
    color: var(--muted); margin-bottom: 1.5rem;
  }

  .empty-btn {
    padding: 0.7rem 1.5rem;
    background: linear-gradient(135deg, var(--indigo), var(--indigo-dark));
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
    text-decoration: none;
    display: inline-block;
  }

  .empty-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 24px rgba(79,70,229,0.3);
  }

  /* ── PAGINATION ── */
  .pagination-wrapper {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
    gap: 0.5rem;
  }

  .pagination a,
  .pagination span {
    padding: 0.6rem 0.9rem;
    border-radius: 8px;
    border: 1px solid var(--card-border);
    background: rgba(255,255,255,0.05);
    color: var(--text);
    text-decoration: none;
    font-size: 0.85rem;
    transition: 0.2s;
  }

  .pagination a:hover {
    border-color: var(--indigo);
    background: rgba(79,70,229,0.1);
    color: var(--indigo-light);
  }

  .pagination .active span {
    background: linear-gradient(135deg, var(--indigo), var(--indigo-dark));
    color: white;
    border-color: var(--indigo);
  }

  .pagination .disabled span {
    opacity: 0.5; cursor: not-allowed;
  }
</style>

<div class="orders-container">
  <!-- PAGE HEADER -->
  <div class="page-header">
    <h1 class="page-title">Riwayat Pesanan</h1>
    <p class="page-subtitle">Pantau status pembelian dan penyewaan Anda</p>
  </div>

  <!-- FILTERS -->
  <form method="GET" class="filters-row">
    <div class="filter-group">
      <label class="filter-label">Cari Order</label>
      <input type="text" name="search" class="filter-input" placeholder="Order ID atau produk..." value="{{ request('search') }}">
    </div>

    <div class="filter-group">
      <label class="filter-label">Jenis</label>
      <select name="type" class="filter-select">
        <option value="semua">Semua</option>
        <option value="beli" {{ request('type') === 'beli' ? 'selected' : '' }}>Beli</option>
        <option value="sewa" {{ request('type') === 'sewa' ? 'selected' : '' }}>Sewa</option>
      </select>
    </div>

    <div class="filter-group">
      <label class="filter-label">Status</label>
      <select name="status" class="filter-select">
        <option value="semua">Semua Status</option>
        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pembayaran Pending</option>
        <option value="masuk" {{ request('status') === 'masuk' ? 'selected' : '' }}>Pesanan Masuk</option>
        <option value="proses" {{ request('status') === 'proses' ? 'selected' : '' }}>Diproses</option>
        <option value="kirim" {{ request('status') === 'kirim' ? 'selected' : '' }}>Dikirim</option>
        <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
      </select>
    </div>

    <button type="submit" class="filter-btn">Filter</button>
  </form>

  <!-- STATUS CHIPS -->
  <div class="status-chips">
    <a href="{{ route('orders.buyer') }}" class="chip {{ !request('status') ? 'active' : '' }}">
      Semua ({{ $statusCounts['semua'] }})
    </a>
    <a href="{{ route('orders.buyer', ['status' => 'pending']) }}" class="chip {{ request('status') === 'pending' ? 'active' : '' }}">
      💳 Pending ({{ $statusCounts['pending'] }})
    </a>
    <a href="{{ route('orders.buyer', ['status' => 'masuk']) }}" class="chip {{ request('status') === 'masuk' ? 'active' : '' }}">
      📥 Masuk ({{ $statusCounts['masuk'] }})
    </a>
    <a href="{{ route('orders.buyer', ['status' => 'proses']) }}" class="chip {{ request('status') === 'proses' ? 'active' : '' }}">
      ⚙️ Proses ({{ $statusCounts['proses'] }})
    </a>
    <a href="{{ route('orders.buyer', ['status' => 'kirim']) }}" class="chip {{ request('status') === 'kirim' ? 'active' : '' }}">
      🚚 Kirim ({{ $statusCounts['kirim'] }})
    </a>
    <a href="{{ route('orders.buyer', ['status' => 'selesai']) }}" class="chip {{ request('status') === 'selesai' ? 'active' : '' }}">
      ✅ Selesai ({{ $statusCounts['selesai'] }})
    </a>
  </div>

  <!-- ORDERS LIST -->
  @if($orders->count() > 0)
    <div class="orders-list">
      @foreach($orders as $order)
        <a href="{{ route('orders.show', $order) }}" class="order-card" style="text-decoration:none;color:inherit">
          <div class="order-header">
            <div class="order-id">
              <div class="order-number">{{ $order->order_number }}</div>
              <div class="order-code">{{ $order->order_code }}</div>
            </div>
            <div class="order-badges">
              <span class="badge badge-type-{{ $order->type }}">
                {{ $order->type === 'beli' ? 'Beli' : 'Sewa' }}
              </span>
              <span class="badge badge-status-{{ $order->status }}">
                @switch($order->status)
                  @case('masuk') Pesanan Masuk @break
                  @case('proses') Diproses @break
                  @case('kirim') Dikirim @break
                  @case('selesai') Selesai @break
                  @case('dibatalkan') Dibatalkan @break
                  @default {{ $order->status }} @endswitch
              </span>
              <span class="badge {{ $order->payment_status === 'paid' ? 'badge-paid' : 'badge-unpaid' }}">
                {{ $order->payment_status === 'paid' ? '✓ Lunas' : '⚠ Pending Bayar' }}
              </span>
            </div>
          </div>

          <div class="order-items">
            @foreach($order->items->take(2) as $item)
              <div class="item-preview">
                <div class="item-image">
                  <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}" loading="lazy">
                </div>
                <div class="item-info">
                  <div class="item-name">{{ $item->product_name }}</div>
                  <div class="item-qty">Qty: {{ $item->quantity }} × Rp {{ number_format($item->unit_price, 0, ',', '.') }}</div>
                </div>
              </div>
            @endforeach
            @if($order->items->count() > 2)
              <div style="padding:1rem;text-align:center;color:var(--muted);font-size:0.85rem">
                +{{ $order->items->count() - 2 }} item lainnya
              </div>
            @endif
          </div>

          <div class="order-footer">
            <div class="order-meta">
              <div class="meta-item">
                <div class="meta-label">Toko</div>
                <div class="meta-value">{{ $order->shop->name ?? 'N/A' }}</div>
              </div>
              <div class="meta-item">
                <div class="meta-label">Total</div>
                <div class="meta-value">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
              </div>
              <div class="meta-item">
                <div class="meta-label">Tanggal</div>
                <div class="meta-value">{{ $order->created_at->format('d M Y') }}</div>
              </div>
            </div>
            <button type="button" class="order-action" onclick="event.preventDefault(); window.location='{{ route('orders.show', $order) }}'">
              Lihat Detail →
            </button>
          </div>
        </a>
      @endforeach
    </div>

    <!-- PAGINATION -->
    @if($orders->hasPages())
      <div class="pagination-wrapper">
        {{ $orders->links() }}
      </div>
    @endif
  @else
    <!-- EMPTY STATE -->
    <div class="empty-state">
      <div class="empty-icon">📦</div>
      <div class="empty-title">Belum ada pesanan</div>
      <p class="empty-text">Anda belum melakukan pembelian atau penyewaan apapun.</p>
      <a href="{{ route('catalog') }}" class="empty-btn">Mulai Belanja Sekarang →</a>
    </div>
  @endif
</div>
@endsection
