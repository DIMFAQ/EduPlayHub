<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_code')->unique()->nullable()->after('order_number');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'expired', 'cancelled'])->default('pending')->after('payment_method');
            $table->string('midtrans_order_id')->nullable()->after('payment_status');
            $table->text('midtrans_token')->nullable()->after('midtrans_order_id');
            $table->text('notes')->nullable()->after('voucher_code');
            $table->string('type_transaction', 50)->default('buy')->after('type');
            $table->integer('duration_days')->nullable()->after('rental_days');
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null')->after('seller_id');
            $table->enum('status', ['open', 'closed'])->default('open')->after('product_id');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->string('type')->default('text')->after('body');
            $table->string('attachment_url')->nullable()->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['order_code', 'payment_status', 'midtrans_order_id', 'midtrans_token', 'notes', 'type_transaction', 'duration_days']);
        });

        Schema::table('conversations', function (Blueprint $table) {
            $table->dropColumn(['product_id', 'status']);
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn(['type', 'attachment_url']);
        });
    }
};
