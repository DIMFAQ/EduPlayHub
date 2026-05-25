<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $avgRating = $this->reviews->avg('rating') ?? 0;
        $reviewCount = $this->reviews->count();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug ?? str()->slug($this->name),
            'description' => $this->description,
            'category' => [
                'id' => $this->category->id ?? null,
                'name' => $this->category->name ?? null,
            ],
            'shop' => [
                'id' => $this->shop->id ?? null,
                'name' => $this->shop->name ?? null,
            ],
            'price_buy' => $this->price_buy,
            'price_rent' => $this->price_rent,
            'sellable' => $this->sellable,
            'rentable' => $this->rentable,
            'stock' => $this->stock,
            'rating' => round($avgRating, 1),
            'review_count' => $reviewCount,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'images' => $this->images->map(function ($img) {
                return [
                    'id' => $img->id,
                    'url' => asset('storage/' . $img->image_path),
                ];
            }),
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
        ];
    }
}
