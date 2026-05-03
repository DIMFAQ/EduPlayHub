<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model {
    protected $fillable = ['code','description','discount_percent','max_discount','min_order','is_active','expires_at'];
    protected $casts    = ['is_active' => 'boolean', 'expires_at' => 'date'];

    public function isValid(): bool
    {
        if (!$this->is_active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        return true;
    }

    public function calcDiscount(float $subtotal): float
    {
        $discount = $subtotal * ($this->discount_percent / 100);
        if ($this->max_discount) {
            $discount = min($discount, $this->max_discount);
        }
        return $discount;
    }
}
