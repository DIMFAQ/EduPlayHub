<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'shop_id', 'category_id', 'name', 'description', 'image',
        'price_rent', 'price_buy', 'rentable', 'sellable',
        'stock', 'location', 'rating', 'total_rented', 'is_active',
    ];

    protected $casts = [
        'rentable'  => 'boolean',
        'sellable'  => 'boolean',
        'is_active' => 'boolean',
    ];

    // ─── RELATIONS ──────────────────────────────────
    public function shop()     { return $this->belongsTo(Shop::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function images()   { return $this->hasMany(ProductImage::class)->orderBy('sort_order'); }
    public function variants() { return $this->hasMany(ProductVariant::class); }
    public function reviews()  { return $this->hasMany(Review::class); }

    // ─── HELPERS ────────────────────────────────────
    public function displayPrice(): string
    {
        $price = $this->price_rent ?? $this->price_buy;
        return 'Rp ' . number_format($price, 0, ',', '.');
    }

    public function mainImage(): string
    {
        return $this->image ?? 'https://picsum.photos/id/20/500/400';
    }

    public function scopeActive($q)  { return $q->where('is_active', true); }
    public function scopeRentable($q){ return $q->where('rentable', true); }
    public function scopeSellable($q){ return $q->where('sellable', true); }
}
