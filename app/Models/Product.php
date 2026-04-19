<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image_url',
        'type',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function itemPesanan()
    {
        return $this->hasMany(OrderItem::class, 'produk_id');
    }
}

