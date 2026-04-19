<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'pesanan_id',
        'amount',
        'status',
        'proof_image_path',
        'qris_code',
        'verified_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'verified_at' => 'datetime',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Order::class, 'pesanan_id');
    }
}
