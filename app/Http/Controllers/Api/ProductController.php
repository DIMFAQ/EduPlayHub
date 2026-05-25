<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['images', 'reviews', 'shop', 'category'])->active();

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) {
                $q->where('slug', request('category'));
            });
        }

        if ($request->filled('type')) {
            $type = $request->type;
            if ($type === 'buy') {
                $query->where('sellable', true);
            } elseif ($type === 'rent') {
                $query->where('rentable', true);
            }
        }

        if ($request->filled('min_price')) {
            $minPrice = $request->min_price;
            $query->where(function ($q) use ($minPrice) {
                $q->where('price_buy', '>=', $minPrice)
                  ->orWhere('price_rent', '>=', $minPrice);
            });
        }

        if ($request->filled('max_price')) {
            $maxPrice = $request->max_price;
            $query->where(function ($q) use ($maxPrice) {
                $q->where('price_buy', '<=', $maxPrice)
                  ->orWhere('price_rent', '<=', $maxPrice);
            });
        }

        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where('name', 'like', $search)
                  ->orWhere('description', 'like', $search);
        }

        $perPage = $request->get('per_page', 12);
        $products = $query->paginate($perPage);

        return response()->json([
            'data' => ProductResource::collection($products->items()),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with(['images', 'reviews.user', 'shop'])->firstOrFail();

        return response()->json([
            'data' => new ProductResource($product),
        ]);
    }
}
