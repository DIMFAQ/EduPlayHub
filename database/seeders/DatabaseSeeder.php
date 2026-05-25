<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        // ─── CATEGORIES ─────────────────────────────
        $categories = [
            ['name' => 'Elektronik Edukasi', 'slug' => 'elektronik-edukasi', 'icon' => 'laptop'],
            ['name' => 'Alat Peraga',         'slug' => 'alat-peraga',         'icon' => 'beaker'],
            ['name' => 'Mainan Edukatif',     'slug' => 'mainan-edukatif',     'icon' => 'puzzle'],
            ['name' => 'Buku & Media',        'slug' => 'buku-media',          'icon' => 'book'],
            ['name' => 'Robotika',            'slug' => 'robotika',            'icon' => 'robot'],
            ['name' => 'Sains & Lab',         'slug' => 'sains-lab',           'icon' => 'flask'],
        ];
        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // ─── DEMO BUYER ─────────────────────────────
        $buyer = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'buyer@demo.com',
            'password' => Hash::make('password'),
            'role'     => 'buyer',
            'phone'    => '08123456789',
            'address'  => 'Jl. Merdeka No. 10',
            'city'     => 'Jakarta Selatan',
            'province' => 'DKI Jakarta',
            'postal_code' => '12190',
        ]);

        // ─── DEMO SELLERS ────────────────────────────
        $sellers = [
            [
                'user' => ['name' => 'Toko EduTech', 'email' => 'seller@demo.com', 'city' => 'Bandar Lampung'],
                'shop' => ['name' => 'EduTech Store', 'city' => 'Bandar Lampung', 'rating' => 4.8, 'total_sales' => 234],
            ],
        ];

        $shopModels = [];
        foreach ($sellers as $i => $s) {
            $user = User::create([
                'name'     => $s['user']['name'],
                'email'    => $s['user']['email'],
                'password' => Hash::make('password'),
                'role'     => 'seller',
                'city'     => $s['user']['city'],
            ]);
            $shop = Shop::create(array_merge($s['shop'], ['user_id' => $user->id, 'balance' => rand(500000, 5000000)]));
            $shopModels[] = $shop;
        }

        // ─── PRODUCTS ────────────────────────────────
        $products = [
            // EduTech Store
            ['shop_idx'=>0,'cat'=>'Elektronik Edukasi','name'=>'Laptop Edukasi Asus E210','price_rent'=>35000,'price_buy'=>4500000,'stock'=>8,'location'=>'Bandar Lampung','desc'=>'Laptop ringan untuk keperluan belajar, sudah terinstall software pendidikan.','rentable'=>true,'sellable'=>true,'img'=>'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=600&q=60'],
            ['shop_idx'=>0,'cat'=>'Elektronik Edukasi','name'=>'Tablet Android Huawei MatePad','price_rent'=>25000,'price_buy'=>2800000,'stock'=>12,'location'=>'Bandar Lampung','desc'=>'Tablet Android dengan layar 10 inci, ideal untuk membaca dan belajar online.','rentable'=>true,'sellable'=>true,'img'=>'https://images.unsplash.com/photo-1585790050230-5dd28404ccb9?auto=format&fit=crop&w=600&q=60'],
            ['shop_idx'=>0,'cat'=>'Robotika','name'=>'Kit Robot Arduino Starter','price_rent'=>20000,'price_buy'=>350000,'stock'=>15,'location'=>'Bandar Lampung','desc'=>'Paket lengkap belajar robotika dengan Arduino UNO, breadboard, dan komponen.','rentable'=>true,'sellable'=>true,'img'=>'https://images.unsplash.com/photo-1553406830-ef2513450d76?auto=format&fit=crop&w=600&q=60'],
            ['shop_idx'=>0,'cat'=>'Mainan Edukatif','name'=>'LEGO Education Spike Essential','price_rent'=>40000,'price_buy'=>1800000,'stock'=>6,'location'=>'Bandar Lampung','desc'=>'Set LEGO Education untuk belajar coding dan mekatronika secara menyenangkan.','rentable'=>true,'sellable'=>false,'img'=>'https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=600&q=60'],
            ['shop_idx'=>0,'cat'=>'Sains & Lab','name'=>'Mikroskop Digital 1000x','price_rent'=>45000,'price_buy'=>850000,'stock'=>5,'location'=>'Bandar Lampung','desc'=>'Mikroskop digital dengan pembesaran hingga 1000x dan koneksi USB ke komputer.','rentable'=>true,'sellable'=>true,'img'=>'https://images.unsplash.com/photo-1516979187457-637abb4f9353?auto=format&fit=crop&w=600&q=60'],
            ['shop_idx'=>0,'cat'=>'Alat Peraga','name'=>'Globe Interaktif 3D','price_rent'=>15000,'price_buy'=>280000,'stock'=>10,'location'=>'Bandar Lampung','desc'=>'Globe interaktif dengan augmented reality, scan dengan app untuk info detail.','rentable'=>true,'sellable'=>true,'img'=>'https://images.unsplash.com/photo-1521295121783-8a321d551ad2?auto=format&fit=crop&w=600&q=60'],
            ['shop_idx'=>0,'cat'=>'Sains & Lab','name'=>'Kit Kimia Eksperimen Aman','price_rent'=>30000,'price_buy'=>450000,'stock'=>8,'location'=>'Bandar Lampung','desc'=>'Set eksperimen kimia aman untuk anak SD-SMP, sudah termasuk panduan lengkap.','rentable'=>true,'sellable'=>true,'img'=>'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=600&q=60'],
            ['shop_idx'=>0,'cat'=>'Buku & Media','name'=>'Ensiklopedi Sains Anak 10 Jilid','price_rent'=>10000,'price_buy'=>650000,'stock'=>20,'location'=>'Bandar Lampung','desc'=>'Kumpulan buku ensiklopedi sains lengkap untuk anak usia 6-15 tahun.','rentable'=>true,'sellable'=>true,'img'=>'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=600&q=60'],
            ['shop_idx'=>0,'cat'=>'Robotika','name'=>'mBot STEM Robot Kit','price_rent'=>35000,'price_buy'=>900000,'stock'=>7,'location'=>'Bandar Lampung','desc'=>'Robot programmable Makeblock mBot, cocok untuk belajar pemrograman Scratch dan Arduino.','rentable'=>true,'sellable'=>true,'img'=>'https://images.unsplash.com/photo-1535378917042-10a22c95931a?auto=format&fit=crop&w=600&q=60'],
            ['shop_idx'=>0,'cat'=>'Mainan Edukatif','name'=>'Puzzle 3D Sistem Tata Surya','price_rent'=>12000,'price_buy'=>180000,'stock'=>15,'location'=>'Bandar Lampung','desc'=>'Puzzle 3D edukatif sistem tata surya, bisa dirakit menjadi model yang bisa digantung.','rentable'=>true,'sellable'=>true,'img'=>'https://images.unsplash.com/photo-1462331940025-496dfbfc7564?auto=format&fit=crop&w=600&q=60'],
            ['shop_idx'=>0,'cat'=>'Elektronik Edukasi','name'=>'Coding Mouse Bee-Bot','price_rent'=>18000,'price_buy'=>420000,'stock'=>10,'location'=>'Bandar Lampung','desc'=>'Robot mouse Bee-Bot untuk belajar konsep dasar coding tanpa layar.','rentable'=>true,'sellable'=>true,'img'=>'https://images.unsplash.com/photo-1531492746076-161ca9bcad58?auto=format&fit=crop&w=600&q=60'],
            ['shop_idx'=>0,'cat'=>'Alat Peraga','name'=>'Planetarium Portable Kecil','price_rent'=>50000,'price_buy'=>1200000,'stock'=>4,'location'=>'Bandar Lampung','desc'=>'Proyektor planetarium portabel untuk menampilkan langit berbintang di dalam ruangan.','rentable'=>true,'sellable'=>false,'img'=>'https://images.unsplash.com/photo-1419242902214-272b3f66ee7a?auto=format&fit=crop&w=600&q=60'],
        ];

        $catMap = Category::pluck('id', 'name');
        $createdProducts = [];
        foreach ($products as $p) {
            $shop = $shopModels[$p['shop_idx']];
            $product = Product::create([
                'shop_id'     => $shop->id,
                'category_id' => $catMap[$p['cat']],
                'name'        => $p['name'],
                'description' => $p['desc'],
                'image'       => $p['img'],
                'price_rent'  => $p['price_rent'],
                'price_buy'   => $p['price_buy'],
                'rentable'    => $p['rentable'],
                'sellable'    => $p['sellable'],
                'stock'       => $p['stock'],
                'location'    => $p['location'],
                'rating'      => round(rand(42, 50) / 10, 1),
                'total_rented'=> rand(10, 120),
                'is_active'   => true,
            ]);
            $createdProducts[] = $product;
        }

        // ─── REVIEWS ─────────────────────────────────
        $comments = [
            'Produk sangat bagus, anak saya senang belajar menggunakannya!',
            'Kondisi barang mulus, pengiriman cepat. Highly recommended!',
            'Penjual responsif dan ramah. Barang sesuai deskripsi.',
            'Kualitas produk premium, worth every penny!',
            'Sangat membantu untuk kegiatan belajar di rumah.',
        ];
        foreach (array_slice($createdProducts, 0, 6) as $product) {
            for ($i = 0; $i < rand(2, 4); $i++) {
                Review::create([
                    'product_id' => $product->id,
                    'user_id'    => $buyer->id,
                    'order_id'   => 1, // placeholder
                    'rating'     => rand(4, 5),
                    'comment'    => $comments[array_rand($comments)],
                ]);
            }
        }

        // ─── VOUCHERS ────────────────────────────────
        $vouchers = [
            ['code' => 'PROMO10',  'description' => 'Diskon 10%',         'discount_percent' => 10, 'max_discount' => 50000,  'min_order' => 100000],
            ['code' => 'HEMAT20',  'description' => 'Diskon 20% maks 100rb','discount_percent'=> 20, 'max_discount' => 100000, 'min_order' => 200000],
            ['code' => 'NEWUSER',  'description' => 'Diskon 15% user baru','discount_percent' => 15, 'max_discount' => 75000,  'min_order' => 50000],
            ['code' => 'EDUFEST',  'description' => 'Festival Pendidikan 25%','discount_percent'=>25,'max_discount' => 200000, 'min_order' => 300000],
        ];
        foreach ($vouchers as $v) {
            Voucher::create(array_merge($v, [
                'is_active'  => true,
                'expires_at' => now()->addMonths(3)->toDateString(),
            ]));
        }

        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
    }
}
