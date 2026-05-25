<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string|null $avatar
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $city
 * @property string|null $province
 * @property string|null $postal_code
 * @property-read \Illuminate\Database\Eloquent\Collection $cartItems
 * @property-read \Illuminate\Database\Eloquent\Collection $orders
 * @property-read \Illuminate\Database\Eloquent\Collection $sentMessages
 * @method int cartCount() Get cart item count
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'avatar', 'phone', 'address', 'city', 'province', 'postal_code',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    // ─── RELATIONS ──────────────────────────────────
    public function shop()
    {
        return $this->hasOne(Shop::class);
    }

    public function cartItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // ─── HELPERS ────────────────────────────────────
    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    public function cartCount(): int
    {
        return (int) $this->cartItems()->count();
    }

    public function initials(): string
    {
        $parts = explode(' ', $this->name);
        return strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
    }
}
