<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $shop_id
 * @property string|null $image
 */
class Product extends Model
{
    protected $fillable = [
        'shop_id', 'category_id', 'name', 'slug', 'description', 'image',
        'price_rent', 'price_buy', 'rentable', 'sellable',
        'stock', 'location', 'rating', 'total_rented', 'is_active',
    ];

    protected $casts = [
        'rentable'  => 'boolean',
        'sellable'  => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = \Illuminate\Support\Str::slug($product->name);
            }
        });
        static::updating(function ($product) {
            $product->slug = \Illuminate\Support\Str::slug($product->name);
        });
    }

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
        if (!$this->image) {
            return 'https://images.unsplash.com/photo-1517430816045-df4b7de11d1d?auto=format&fit=crop&w=600&q=60';
        }
        
        // If image is a full URL (external), return as is
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        
        // If image is a local path, wrap with asset/storage
        return asset('storage/' . $this->image);
    }

    public function scopeActive(Builder $q): Builder  { return $q->where('is_active', true); }
    public function scopeRentable(Builder $q): Builder{ return $q->where('rentable', true); }
    public function scopeSellable(Builder $q): Builder{ return $q->where('sellable', true); }
}
