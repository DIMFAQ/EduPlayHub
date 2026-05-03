@extends('admin.layout')

@section('content')
<h2 class="text-2xl font-bold text-slate-800 mb-6">Edit Produk</h2>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST"
      class="bg-white/70 backdrop-blur-xl rounded-2xl border border-blue-200/40 shadow p-6 space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Produk</label>
        <input type="text" name="name" value="{{ $product->name }}"
            class="w-full px-4 py-3 rounded-xl border border-blue-200 focus:ring-2 focus:ring-blue-300 outline-none"
            required>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori</label>
        <select name="category"
            class="w-full px-4 py-3 rounded-xl border border-blue-200 focus:ring-2 focus:ring-blue-300 outline-none"
            required>
            <option value="PS" {{ $product->category == 'PS' ? 'selected' : '' }}>PS</option>
            <option value="Laptop" {{ $product->category == 'Laptop' ? 'selected' : '' }}>Laptop</option>
            <option value="Dataset" {{ $product->category == 'Dataset' ? 'selected' : '' }}>Dataset</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Harga per Hari</label>
        <input type="number" name="price_per_day" value="{{ $product->price_per_day }}"
            class="w-full px-4 py-3 rounded-xl border border-blue-200 focus:ring-2 focus:ring-blue-300 outline-none"
            required>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Stok</label>
        <input type="number" name="stock" value="{{ $product->stock }}"
            class="w-full px-4 py-3 rounded-xl border border-blue-200 focus:ring-2 focus:ring-blue-300 outline-none"
            required>
    </div>

    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi</label>
        <textarea name="description"
            class="w-full px-4 py-3 rounded-xl border border-blue-200 focus:ring-2 focus:ring-blue-300 outline-none">{{ $product->description }}</textarea>
    </div>

    <div class="flex gap-3">
        <button type="submit"
            class="px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
            Update
        </button>

        <a href="{{ route('admin.products.index') }}"
            class="px-6 py-3 rounded-xl bg-slate-400 text-white font-semibold hover:bg-slate-500 transition">
            Kembali
        </a>
    </div>
</form>
@endsection