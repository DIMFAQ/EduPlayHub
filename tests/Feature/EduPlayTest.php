<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EduPlayTest extends TestCase
{
    use RefreshDatabase;

    private function createCategoryAndProduct()
    {
        $category = Category::create([
            'name' => 'Alat Musik',
            'slug' => 'alat-musik',
        ]);

        $seller = User::create([
            'name' => 'Toko Musik Jaya',
            'email' => 'seller@demo.com',
            'password' => bcrypt('password'),
            'role' => 'seller',
        ]);

        $shop = Shop::create([
            'user_id' => $seller->id,
            'name' => 'Toko Musik Jaya',
            'city' => 'Jakarta',
            'balance' => 0,
        ]);

        $product = Product::create([
            'shop_id' => $shop->id,
            'category_id' => $category->id,
            'name' => 'Gitar Akustik Yamaha',
            'price_buy' => 1500000,
            'price_rent' => 50000,
            'rentable' => true,
            'sellable' => true,
            'stock' => 10,
            'is_active' => true,
        ]);

        return [$category, $seller, $shop, $product];
    }

    /**
     * Test order history pending status filtering.
     */
    public function test_buyer_pending_orders_list_shows_correct_records(): void
    {
        [$category, $seller, $shop, $product] = $this->createCategoryAndProduct();

        $buyer = User::create([
            'name' => 'Budi Santoso',
            'email' => 'buyer@demo.com',
            'password' => bcrypt('password'),
            'role' => 'buyer',
        ]);

        // Unpaid pending order (transfer)
        $orderPending = Order::create([
            'order_number' => 'EPH-PENDING1',
            'order_code' => 'ORD-PENDING1',
            'user_id' => $buyer->id,
            'shop_id' => $shop->id,
            'type' => 'beli',
            'type_transaction' => 'buy',
            'status' => 'masuk',
            'payment_status' => 'pending',
            'payment_method' => 'transfer',
            'recipient_name' => 'Budi',
            'address' => 'Jl. Kenangan',
            'city' => 'Jakarta',
            'postal_code' => '12345',
            'phone' => '08123',
            'subtotal' => 1500000,
            'shipping_cost' => 15000,
            'discount' => 0,
            'total' => 1515000,
        ]);

        // Paid order (transfer)
        $orderPaid = Order::create([
            'order_number' => 'EPH-PAID1',
            'order_code' => 'ORD-PAID1',
            'user_id' => $buyer->id,
            'shop_id' => $shop->id,
            'type' => 'beli',
            'type_transaction' => 'buy',
            'status' => 'masuk',
            'payment_status' => 'paid',
            'payment_method' => 'transfer',
            'recipient_name' => 'Budi',
            'address' => 'Jl. Kenangan',
            'city' => 'Jakarta',
            'postal_code' => '12345',
            'phone' => '08123',
            'subtotal' => 1500000,
            'shipping_cost' => 15000,
            'discount' => 0,
            'total' => 1515000,
        ]);

        $this->actingAs($buyer);

        // Verify counts
        $response = $this->get(route('orders.buyer', ['status' => 'pending']));
        $response->assertStatus(200);

        // Assert pending order is in view, paid order is not
        $response->assertSee('EPH-PENDING1');
        $response->assertDontSee('EPH-PAID1');
    }

    /**
     * Test quick checkout index does not crash with Undefined Property exceptions.
     */
    public function test_quick_checkout_does_not_crash(): void
    {
        [$category, $seller, $shop, $product] = $this->createCategoryAndProduct();

        $buyer = User::create([
            'name' => 'Budi Santoso',
            'email' => 'buyer@demo.com',
            'password' => bcrypt('password'),
            'role' => 'buyer',
            'phone' => '08123456789',
            'address' => 'Jl. Merdeka',
            'city' => 'Jakarta',
            'postal_code' => '12345',
        ]);

        $this->actingAs($buyer);

        $response = $this->get(route('checkout.index', [
            'product' => $product->id,
            'type' => 'beli'
        ]));

        $response->assertStatus(200);
        $response->assertSee($product->name);
    }

    /**
     * Test API checkout returns 422 for incomplete profile but works if explicit recipient info is passed.
     */
    public function test_api_checkout_recipient_validation(): void
    {
        [$category, $seller, $shop, $product] = $this->createCategoryAndProduct();

        // Buyer with incomplete profile (null address/phone/etc)
        $buyer = User::create([
            'name' => 'Budi Santoso',
            'email' => 'buyer@demo.com',
            'password' => bcrypt('password'),
            'role' => 'buyer',
            'phone' => null,
            'address' => null,
            'city' => null,
            'postal_code' => null,
        ]);

        $this->actingAs($buyer, 'sanctum');

        // Call API checkout without recipient info
        $response = $this->postJson('/api/transactions', [
            'items' => [
                [
                    'product_id' => $product->id,
                    'qty' => 1,
                    'type' => 'buy',
                ]
            ]
        ]);

        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'Recipient information is incomplete. Please provide recipient_name, address, city, postal_code, and phone in the request or complete your profile.',
        ]);

        // Call API checkout WITH explicit recipient info
        $responseSuccess = $this->postJson('/api/transactions', [
            'items' => [
                [
                    'product_id' => $product->id,
                    'qty' => 1,
                    'type' => 'buy',
                ]
            ],
            'recipient_name' => 'Budi Santoso',
            'address' => 'Jl. Raya No 10',
            'city' => 'Jakarta Selatan',
            'postal_code' => '12190',
            'phone' => '08123456789',
        ]);

        $responseSuccess->assertStatus(201);
        $responseSuccess->assertJsonStructure([
            'message', 'order_id', 'snap_token', 'total_price'
        ]);
    }

    /**
     * Test web chat message sending and retrieving.
     */
    public function test_web_chat_functionality(): void
    {
        [$category, $seller, $shop, $product] = $this->createCategoryAndProduct();

        $buyer = User::create([
            'name' => 'Budi Santoso',
            'email' => 'buyer@demo.com',
            'password' => bcrypt('password'),
            'role' => 'buyer',
        ]);

        $this->actingAs($buyer);

        // Send a message via AJAX
        $responseSend = $this->postJson(route('chat.send', $seller), [
            'body' => 'Halo, apakah produk ini ready?'
        ]);

        $responseSend->assertStatus(200);
        $responseSend->assertJsonStructure([
            'id', 'body', 'sender_id', 'created_at'
        ]);

        // Get messages list via AJAX
        $responseGet = $this->getJson(route('chat.messages', $seller));
        $responseGet->assertStatus(200);
        
        $data = $responseGet->json();
        $this->assertCount(1, $data);
        $this->assertEquals('Halo, apakah produk ini ready?', $data[0]['body']);
        $this->assertTrue($data[0]['mine']);
    }

    /**
     * Test API products list returns correct main image URL (no local storage prefix for external URLs).
     */
    public function test_api_products_list_returns_correct_main_image_url(): void
    {
        [$category, $seller, $shop, $product] = $this->createCategoryAndProduct();

        // Update product to use an external Unsplash image URL
        $product->update([
            'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853'
        ]);

        $response = $this->getJson('/api/products');
        $response->assertStatus(200);
        
        $data = $response->json('data');
        $this->assertNotEmpty($data);
        $this->assertEquals('https://images.unsplash.com/photo-1496181133206-80ce9b88a853', $data[0]['image']);
    }
}
