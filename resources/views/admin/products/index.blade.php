@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Manajemen Produk</h2>
    <a href="{{ route('admin.products.create') }}"
       class="px-5 py-2 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
        + Tambah Produk
    </a>
</div>

<div class="bg-white/70 backdrop-blur-xl rounded-2xl border border-blue-200/40 shadow p-6">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left text-slate-600 border-b">
                <th class="py-3">Nama</th>
                <th>Kategori</th>
                <th>Harga/Hari</th>
                <th>Stok</th>
                <th class="text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr class="border-b border-slate-200/60">
                    <td class="py-3 font-semibold text-slate-800">{{ $product->name }}</td>
                    <td>{{ $product->category }}</td>
                    <td>Rp {{ number_format($product->price_per_day, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td class="text-right flex justify-end gap-2 py-2">
                        <a href="{{ route('admin.products.edit', $product->id) }}"
                           class="px-3 py-1 rounded-lg bg-yellow-400 text-white text-xs font-semibold">
                            Edit
                        </a>

                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('Yakin mau hapus produk ini?')"
                                class="px-3 py-1 rounded-lg bg-red-500 text-white text-xs font-semibold">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-6 text-center text-slate-500">
                        Belum ada produk.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection