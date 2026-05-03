<?php
// database/migrations/2024_01_01_000003_create_carts_orders_chat_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ─── CART ───────────────────────────────────
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('variant')->nullable();
            $table->integer('quantity')->default(1);
            $table->boolean('selected')->default(true);
            $table->timestamps();
        });

        // ─── ORDERS ─────────────────────────────────
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->foreignId('shop_id')->constrained()->onDelete('restrict');
            $table->enum('type', ['beli', 'sewa'])->default('beli');
            $table->enum('status', ['masuk', 'proses', 'kirim', 'selesai', 'dibatalkan'])->default('masuk');
            $table->string('recipient_name');
            $table->text('address');
            $table->string('city');
            $table->string('postal_code');
            $table->string('phone');
            $table->enum('payment_method', ['transfer', 'cod', 'ewallet'])->default('transfer');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('shipping_cost', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('total', 15, 2);
            $table->string('voucher_code')->nullable();
            // rental fields
            $table->date('rental_start')->nullable();
            $table->date('rental_end')->nullable();
            $table->integer('rental_days')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('restrict');
            $table->string('product_name');
            $table->string('variant')->nullable();
            $table->string('product_image')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_price', 15, 2);
            $table->timestamps();
        });

        // ─── VOUCHERS ───────────────────────────────
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('max_discount', 15, 2)->nullable();
            $table->integer('min_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->date('expires_at')->nullable();
            $table->timestamps();
        });

        // ─── CHAT ───────────────────────────────────
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
            $table->unique(['buyer_id', 'seller_id']);
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->text('body');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        // ─── REVIEWS ────────────────────────────────
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');
        Schema::dropIfExists('vouchers');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('cart_items');
    }
};
