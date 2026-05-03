@extends('layouts.seller')
@section('title', 'Produk Saya')
@section('page-title', 'Produk Saya')

@section('topbar-actions')
<button class="btn btn-primary" onclick="openModal('addModal')">+ Tambah Produk</button>
@endsection

@push('styles')
<style>
.products-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:16px}
.product-card{background:white;border-radius:18px;overflow:hidden;border:1px solid var(--border-soft);box-shadow:var(--shadow-soft);transition:0.2s}
.product-card:hover{transform:translateY(-2px);box-shadow:0 12px 28px rgba(13,31,60,0.09)}
.product-card img{width:100%;height:150px;object-fit:cover}
.card-body{padding:14px}
.product-name{font-size:14px;font-weight:700;margin-bottom:4px}
.product-cat{font-size:11px;color:var(--accent);font-weight:600;margin-bottom:6px}
.product-price{font-size:15px;font-weight:700;margin-bottom:8px}
.badges{display:flex;gap:6px;margin-bottom:10px;flex-wrap:wrap}
.badge{padding:2px 9px;border-radius:20px;font-size:10px;font-weight:600}
.badge-rent{background:rgba(99,102,241,0.1);color:#4f46e5}
.badge-buy{background:rgba(34,197,94,0.1);color:#16a34a}
.badge-inactive{background:rgba(239,68,68,0.1);color:#dc2626}
.card-actions{display:flex;gap:6px}
.btn-sm{padding:6px 12px;border-radius:10px;font-size:12px;font-weight:600;border:1px solid var(--border-soft);background:white;color:var(--ink);cursor:pointer;font-family:inherit;text-decoration:none;display:inline-flex;align-items:center}
.btn-sm:hover{border-color:var(--accent);color:var(--accent)}
.btn-sm.danger:hover{border-color:#dc2626;color:#dc2626}
/* Modal */
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(13,31,60,0.5);z-index:200;align-items:center;justify-content:center;padding:20px}
.modal-overlay.open{display:flex}
.modal{background:white;border-radius:24px;padding:32px;max-width:600px;width:100%;max-height:90vh;overflow-y:auto;box-shadow:0 24px 64px rgba(13,31,60,0.18)}
.modal-title{font-size:18px;font-weight:700;margin-bottom:24px;letter-spacing:-0.3px}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.field{display:flex;flex-direction:column;gap:6px}
.field label{font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.04em;color:var(--ink-dim)}
.frost-input,.frost-select,.frost-textarea{padding:10px 14px;border-radius:12px;border:1px solid var(--border-soft);background:var(--bg);font-size:13px;font-family:inherit;color:var(--ink);width:100%}
.frost-input:focus,.frost-select:focus,.frost-textarea:focus{outline:none;border-color:var(--accent);background:white}
.frost-textarea{resize:vertical;min-height:80px}
.check-row{display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer}
.modal-actions{display:flex;gap:10px;justify-content:flex-end;margin-top:20px}
.empty-state{text-align:center;padding:80px;color:var(--ink-dim);grid-column:1/-1}
</style>
@endpush

@section('content')
<div class="products-grid">
  @forelse($products as $product)
  <div class="product-card">
    <img src="{{ $product->mainImage() }}" alt="{{ $product->name }}">
    <div class="card-body">
      <div class="product-cat">{{ $product->category->name }}</div>
      <div class="product-name">{{ $product->name }}</div>
      <div class="product-price">{{ $product->displayPrice() }}</div>
      <div class="badges">
        @if($product->rentable)<span class="badge badge-rent">Sewa</span>@endif
        @if($product->sellable)<span class="badge badge-buy">Beli</span>@endif
        @if(!$product->is_active)<span class="badge badge-inactive">Nonaktif</span>@endif
      </div>
      <div style="font-size:11.5px;color:var(--ink-dim);margin-bottom:10px">Stok: {{ $product->stock }} · Disewa: {{ $product->total_rented }}×</div>
      <div class="card-actions">
        <button class="btn-sm" onclick='openEditModal({!! json_encode(["id"=>$product->id,"name"=>$product->name,"category_id"=>$product->category_id,"price_rent"=>$product->price_rent,"price_buy"=>$product->price_buy,"stock"=>$product->stock,"location"=>$product->location,"description"=>$product->description,"rentable"=>$product->rentable,"sellable"=>$product->sellable]) !!})'>Edit</button>
        <form method="POST" action="{{ route('seller.products.destroy', $product) }}" onsubmit="return confirm('Nonaktifkan produk ini?')">
          @csrf @method('DELETE')
          <button type="submit" class="btn-sm danger">Nonaktifkan</button>
        </form>
      </div>
    </div>
  </div>
  @empty
  <div class="empty-state">
    <p style="font-size:16px;font-weight:600;margin-bottom:8px">Belum ada produk</p>
    <p style="font-size:13px;margin-bottom:20px">Tambahkan produk pertama Anda</p>
    <button class="btn btn-primary" onclick="openModal('addModal')">+ Tambah Produk</button>
  </div>
  @endforelse
</div>

{{ $products->links() }}

<!-- ADD MODAL -->
<div class="modal-overlay" id="addModal">
  <div class="modal">
    <div class="modal-title">Tambah Produk Baru</div>
    <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-grid">
        <div class="field" style="grid-column:1/-1">
          <label>Nama Produk</label>
          <input type="text" name="name" class="frost-input" required placeholder="Nama produk...">
        </div>
        <div class="field">
          <label>Kategori</label>
          <select name="category_id" class="frost-select" required>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="field">
          <label>Lokasi</label>
          <input type="text" name="location" class="frost-input" placeholder="Kota/Lokasi">
        </div>
        <div class="field">
          <label>Harga Sewa/Hari (Rp)</label>
          <input type="number" name="price_rent" class="frost-input" placeholder="0">
        </div>
        <div class="field">
          <label>Harga Beli (Rp)</label>
          <input type="number" name="price_buy" class="frost-input" placeholder="0">
        </div>
        <div class="field">
          <label>Stok</label>
          <input type="number" name="stock" class="frost-input" value="1" min="0" required>
        </div>
        <div class="field">
          <label>Foto Produk</label>
          <input type="file" name="image" class="frost-input" accept="image/*">
        </div>
        <div class="field" style="grid-column:1/-1;flex-direction:row;gap:20px">
          <label class="check-row"><input type="checkbox" name="rentable" value="1" checked> Bisa Disewa</label>
          <label class="check-row"><input type="checkbox" name="sellable" value="1" checked> Bisa Dibeli</label>
        </div>
        <div class="field" style="grid-column:1/-1">
          <label>Deskripsi</label>
          <textarea name="description" class="frost-textarea" placeholder="Deskripsi produk..."></textarea>
        </div>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn btn-secondary" onclick="closeModal('addModal')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Produk</button>
      </div>
    </form>
  </div>
</div>

<!-- EDIT MODAL -->
<div class="modal-overlay" id="editModal">
  <div class="modal">
    <div class="modal-title">Edit Produk</div>
    <form id="editForm" method="POST" enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="form-grid">
        <div class="field" style="grid-column:1/-1">
          <label>Nama Produk</label>
          <input type="text" name="name" id="editName" class="frost-input" required>
        </div>
        <div class="field">
          <label>Kategori</label>
          <select name="category_id" id="editCat" class="frost-select">
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="field">
          <label>Lokasi</label>
          <input type="text" name="location" id="editLocation" class="frost-input">
        </div>
        <div class="field">
          <label>Harga Sewa/Hari</label>
          <input type="number" name="price_rent" id="editRent" class="frost-input">
        </div>
        <div class="field">
          <label>Harga Beli</label>
          <input type="number" name="price_buy" id="editBuy" class="frost-input">
        </div>
        <div class="field">
          <label>Stok</label>
          <input type="number" name="stock" id="editStock" class="frost-input" min="0">
        </div>
        <div class="field">
          <label>Foto Baru (opsional)</label>
          <input type="file" name="image" class="frost-input" accept="image/*">
        </div>
        <div class="field" style="grid-column:1/-1;flex-direction:row;gap:20px">
          <label class="check-row"><input type="checkbox" name="rentable" id="editRentable" value="1"> Bisa Disewa</label>
          <label class="check-row"><input type="checkbox" name="sellable" id="editSellable" value="1"> Bisa Dibeli</label>
        </div>
        <div class="field" style="grid-column:1/-1">
          <label>Deskripsi</label>
          <textarea name="description" id="editDesc" class="frost-textarea"></textarea>
        </div>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
function openModal(id){ document.getElementById(id).classList.add('open'); }
function closeModal(id){ document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', e => { if(e.target === o) o.classList.remove('open'); }));

function openEditModal(p) {
  document.getElementById('editForm').action = '/seller/produk/' + p.id;
  document.getElementById('editName').value = p.name;
  document.getElementById('editCat').value = p.category_id;
  document.getElementById('editRent').value = p.price_rent ?? '';
  document.getElementById('editBuy').value = p.price_buy ?? '';
  document.getElementById('editStock').value = p.stock;
  document.getElementById('editLocation').value = p.location ?? '';
  document.getElementById('editDesc').value = p.description ?? '';
  document.getElementById('editRentable').checked = !!p.rentable;
  document.getElementById('editSellable').checked = !!p.sellable;
  openModal('editModal');
}
</script>
@endpush
