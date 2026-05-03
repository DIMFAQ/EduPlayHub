<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load(['shop', 'category', 'images', 'variants', 'reviews.user']);
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()->limit(4)->get();

        $cartCount = Auth::check() ? Auth::user()->cartCount() : 0;
        $inCart    = Auth::check() && Auth::user()->cartItems()->where('product_id', $product->id)->exists();

        return view('buyer.product', compact('product', 'related', 'cartCount', 'inCart'));
    }
}
