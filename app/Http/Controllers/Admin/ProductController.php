<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price_per_day' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // HANDLE UPLOAD IMAGE
        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }

        // SIMPAN DATA
        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'price_per_day' => $request->price_per_day,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price_per_day' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imageName = $product->image;

        // kalau upload gambar baru
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }

        $product->update([
            'name' => $request->name,
            'category' => $request->category,
            'price_per_day' => $request->price_per_day,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Product $product)
    {
        // hapus file gambar kalau ada
        if ($product->image && file_exists(public_path('images/' . $product->image))) {
            unlink(public_path('images/' . $product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}