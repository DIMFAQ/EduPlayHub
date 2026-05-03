<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['shop', 'category'])
            ->active()
            ->when($request->category && $request->category !== 'all', function ($q) use ($request) {
                $q->whereHas('category', fn($c) => $c->where('slug', $request->category));
            })
            ->when($request->location && $request->location !== 'all', function ($q) use ($request) {
                $q->where('location', $request->location);
            })
            ->when($request->min_price, fn($q) => $q->where(function($inner) use ($request) {
                $inner->where('price_rent', '>=', $request->min_price)
                      ->orWhere('price_buy', '>=', $request->min_price);
            }))
            ->when($request->max_price, fn($q) => $q->where(function($inner) use ($request) {
                $inner->where('price_rent', '<=', $request->max_price)
                      ->orWhere('price_buy', '<=', $request->max_price);
            }))
            ->when($request->trans_type === 'sewa',  fn($q) => $q->where('rentable', true))
            ->when($request->trans_type === 'beli',  fn($q) => $q->where('sellable', true))
            ->when($request->search, function ($q) use ($request) {
                $s = '%' . $request->search . '%';
                $q->where('name', 'like', $s)
                  ->orWhere('description', 'like', $s)
                  ->orWhereHas('shop', fn($sh) => $sh->where('name', 'like', $s));
            });

        $perPage   = (int) ($request->per_page ?? 12);
        $products  = $query->paginate($perPage)->withQueryString();

        $categories = Category::withCount(['products' => fn($q) => $q->active()])->get();
        $locations  = Product::active()->distinct()->pluck('location')->filter()->sort()->values();

        $cartCount = Auth::check() ? Auth::user()->cartCount() : 0;

        return view('buyer.catalog', compact('products', 'categories', 'locations', 'cartCount', 'request'));
    }

    /** JSON endpoint for dynamic filter (AJAX) */
    public function apiProducts(Request $request)
    {
        $products = Product::with(['shop', 'category'])
            ->active()
            ->when($request->category && $request->category !== 'all',
                fn($q) => $q->whereHas('category', fn($c) => $c->where('slug', $request->category)))
            ->paginate(12);

        return response()->json($products);
    }
}
