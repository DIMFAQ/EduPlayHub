@extends('admin.layout')

@section('content')

<div class="space-y-6">

    <div>
        <h2 class="text-3xl font-bold text-slate-800">Tambah Produk</h2>
        <p class="text-slate-500 text-sm">Tambah produk baru ke sistem</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- PREVIEW -->
        <div class="lg:col-span-4 glass p-6 rounded-2xl text-center">

            <div class="w-full h-64 border-2 border-dashed border-blue-300 rounded-2xl flex items-center justify-center overflow-hidden bg-blue-50">

                <img id="preview" class="hidden w-full h-full object-cover">
                <span id="placeholder" class="text-slate-400 text-sm">Preview Gambar</span>

            </div>

        </div>

        <!-- FORM -->
        <div class="lg:col-span-8 glass p-6 rounded-2xl">

            <form action="{{ route('admin.products.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-5">

                @csrf

                <!-- IMAGE -->
                <div>
                    <label class="font-semibold text-sm">Foto Produk</label>
                    <input type="file" name="image" accept="image/*"
                           onchange="previewImage(event)"
                           class="w-full mt-2 p-3 border rounded-xl">
                </div>

                <!-- NAME -->
                <div>
                    <label class="font-semibold text-sm">Nama Produk</label>
                    <input type="text" name="name"
                           class="w-full mt-2 p-3 border rounded-xl" required>
                </div>

                <!-- CATEGORY -->
                <div>
                    <label class="font-semibold text-sm">Kategori</label>
                    <select name="category" class="w-full mt-2 p-3 border rounded-xl">
                        <option>PS</option>
                        <option>Laptop</option>
                        <option>Dataset</option>
                    </select>
                </div>

                <!-- PRICE -->
                <div>
                    <label class="font-semibold text-sm">Harga / Hari</label>
                    <input type="number" name="price_per_day"
                           class="w-full mt-2 p-3 border rounded-xl" required>
                </div>

                <!-- STOCK -->
                <div>
                    <label class="font-semibold text-sm">Stok</label>
                    <input type="number" name="stock"
                           class="w-full mt-2 p-3 border rounded-xl" required>
                </div>

                <!-- DESC -->
                <div>
                    <label class="font-semibold text-sm">Deskripsi</label>
                    <textarea name="description"
                              class="w-full mt-2 p-3 border rounded-xl"></textarea>
                </div>

                <!-- BUTTON -->
                <div class="flex gap-3">
                    <button class="px-6 py-3 bg-blue-600 text-white rounded-xl">
                        Simpan
                    </button>

                    <a href="{{ route('admin.products.index') }}"
                       class="px-6 py-3 bg-slate-400 text-white rounded-xl">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();

    reader.onload = function () {
        document.getElementById('preview').src = reader.result;
        document.getElementById('preview').classList.remove('hidden');
        document.getElementById('placeholder').style.display = 'none';
    }

    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection