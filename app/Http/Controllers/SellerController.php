<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    private function shop()
    {
        return Auth::user()->shop;
    }

    public function dashboard()
    {
        $shop    = $this->shop();
        $orders  = Order::where('shop_id', $shop->id)->with('items')->get();

        $stats = [
            'total_revenue'  => $orders->where('status', 'selesai')->sum('total'),
            'total_orders'   => $orders->count(),
            'active_products'=> $shop->products()->where('is_active', true)->count(),
            'avg_rating'     => $shop->products()->avg('rating') ?? 0,
        ];

        $recentOrders    = $orders->sortByDesc('created_at')->take(5);
        $topProducts     = $shop->products()->orderByDesc('total_rented')->take(5)->get();
        $recentCustomers = Order::where('shop_id', $shop->id)
            ->with('user')
            ->latest()
            ->take(5)
            ->get()
            ->unique('user_id');

        // Monthly revenue chart data (last 6 months)
        $months = collect(range(5, 0))->map(function ($i) use ($shop) {
            $date = now()->subMonths($i);
            $revenue = Order::where('shop_id', $shop->id)
                ->where('status', 'selesai')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total');
            return ['label' => $date->format('M'), 'value' => $revenue];
        });

        return view('seller.dashboard', compact('shop', 'stats', 'recentOrders', 'topProducts', 'recentCustomers', 'months'));
    }

    public function products()
    {
        $shop       = $this->shop();
        $products   = $shop->products()->with('category')->paginate(12);
        $categories = Category::all();
        return view('seller.products', compact('shop', 'products', 'categories'));
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price_rent'  => 'nullable|numeric|min:0',
            'price_buy'   => 'nullable|numeric|min:0',
            'rentable'    => 'boolean',
            'sellable'    => 'boolean',
            'stock'       => 'required|integer|min:0',
            'location'    => 'nullable|string',
            'image'       => 'nullable|image|max:4096',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $this->shop()->products()->create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'image'       => $imagePath,
            'price_rent'  => $request->price_rent,
            'price_buy'   => $request->price_buy,
            'rentable'    => $request->boolean('rentable'),
            'sellable'    => $request->boolean('sellable'),
            'stock'       => $request->stock,
            'location'    => $request->location ?? $this->shop()->city,
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function updateProduct(Request $request, Product $product)
    {
        $this->authorizeProduct($product);

        $data = $request->only(['name','category_id','description','price_rent','price_buy','stock','location','is_active']);
        $data['rentable'] = $request->boolean('rentable');
        $data['sellable'] = $request->boolean('sellable');

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return back()->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroyProduct(Product $product)
    {
        $this->authorizeProduct($product);
        $product->update(['is_active' => false]);
        return back()->with('success', 'Produk dinonaktifkan.');
    }

    public function profile()
    {
        $shop = $this->shop();
        return view('seller.profile', compact('shop'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $shop = $this->shop();

        $request->validate([
            'name'       => 'required|string|max:255',
            'phone'      => 'nullable|string',
            'shop_name'  => 'required|string|max:255',
            'shop_city'  => 'nullable|string',
            'shop_desc'  => 'nullable|string',
            'avatar'     => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        $user->update(['name' => $request->name, 'phone' => $request->phone]);
        $shop->update(['name' => $request->shop_name, 'city' => $request->shop_city, 'description' => $request->shop_desc]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    private function authorizeProduct(Product $product): void
    {
        if ($product->shop_id !== $this->shop()->id) abort(403);
    }
}
