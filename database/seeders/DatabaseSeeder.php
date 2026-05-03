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
            ['name' => 'Elektronik Edukasi', 'slug' => 'elektronik-edukasi', 'icon' => '💻'],
            ['name' => 'Alat Peraga',         'slug' => 'alat-peraga',         'icon' => '🔬'],
            ['name' => 'Mainan Edukatif',     'slug' => 'mainan-edukatif',     'icon' => '🧩'],
            ['name' => 'Buku & Media',        'slug' => 'buku-media',          'icon' => '📚'],
            ['name' => 'Robotika',            'slug' => 'robotika',            'icon' => '🤖'],
            ['name' => 'Sains & Lab',         'slug' => 'sains-lab',           'icon' => '⚗️'],
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
                'user' => ['name' => 'Toko EduTech', 'email' => 'seller@demo.com', 'city' => 'Jakarta'],
                'shop' => ['name' => 'EduTech Store', 'city' => 'Jakarta', 'rating' => 4.8, 'total_sales' => 234],
            ],
            [
                'user' => ['name' => 'Rina Wijaya', 'email' => 'rina@demo.com', 'city' => 'Bandung'],
                'shop' => ['name' => 'ScienceLab Bandung', 'city' => 'Bandung', 'rating' => 4.9, 'total_sales' => 187],
            ],
            [
                'user' => ['name' => 'Doni Prasetyo', 'email' => 'doni@demo.com', 'city' => 'Surabaya'],
                'shop' => ['name' => 'RoboKids SBY', 'city' => 'Surabaya', 'rating' => 4.7, 'total_sales' => 142],
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
            ['shop_idx'=>0,'cat'=>'Elektronik Edukasi','name'=>'Laptop Edukasi Asus E210','price_rent'=>35000,'price_buy'=>4500000,'stock'=>8,'location'=>'Jakarta','desc'=>'Laptop ringan untuk keperluan belajar, sudah terinstall software pendidikan.','rentable'=>true,'sellable'=>true,'img'=>'https://picsum.photos/id/1/500/400'],
            ['shop_idx'=>0,'cat'=>'Elektronik Edukasi','name'=>'Tablet Android Huawei MatePad','price_rent'=>25000,'price_buy'=>2800000,'stock'=>12,'location'=>'Jakarta','desc'=>'Tablet Android dengan layar 10 inci, ideal untuk membaca dan belajar online.','rentable'=>true,'sellable'=>true,'img'=>'https://picsum.photos/id/2/500/400'],
            ['shop_idx'=>0,'cat'=>'Robotika','name'=>'Kit Robot Arduino Starter','price_rent'=>20000,'price_buy'=>350000,'stock'=>15,'location'=>'Jakarta','desc'=>'Paket lengkap belajar robotika dengan Arduino UNO, breadboard, dan komponen.','rentable'=>true,'sellable'=>true,'img'=>'https://picsum.photos/id/3/500/400'],
            ['shop_idx'=>0,'cat'=>'Mainan Edukatif','name'=>'LEGO Education Spike Essential','price_rent'=>40000,'price_buy'=>1800000,'stock'=>6,'location'=>'Jakarta','desc'=>'Set LEGO Education untuk belajar coding dan mekatronika secara menyenangkan.','rentable'=>true,'sellable'=>false,'img'=>'https://picsum.photos/id/4/500/400'],
            // ScienceLab Bandung
            ['shop_idx'=>1,'cat'=>'Sains & Lab','name'=>'Mikroskop Digital 1000x','price_rent'=>45000,'price_buy'=>850000,'stock'=>5,'location'=>'Bandung','desc'=>'Mikroskop digital dengan pembesaran hingga 1000x dan koneksi USB ke komputer.','rentable'=>true,'sellable'=>true,'img'=>'https://picsum.photos/id/5/500/400'],
            ['shop_idx'=>1,'cat'=>'Alat Peraga','name'=>'Globe Interaktif 3D','price_rent'=>15000,'price_buy'=>280000,'stock'=>10,'location'=>'Bandung','desc'=>'Globe interaktif dengan augmented reality, scan dengan app untuk info detail.','rentable'=>true,'sellable'=>true,'img'=>'https://picsum.photos/id/6/500/400'],
            ['shop_idx'=>1,'cat'=>'Sains & Lab','name'=>'Kit Kimia Eksperimen Aman','price_rent'=>30000,'price_buy'=>450000,'stock'=>8,'location'=>'Bandung','desc'=>'Set eksperimen kimia aman untuk anak SD-SMP, sudah termasuk panduan lengkap.','rentable'=>true,'sellable'=>true,'img'=>'https://picsum.photos/id/7/500/400'],
            ['shop_idx'=>1,'cat'=>'Buku & Media','name'=>'Ensiklopedi Sains Anak 10 Jilid','price_rent'=>10000,'price_buy'=>650000,'stock'=>20,'location'=>'Bandung','desc'=>'Kumpulan buku ensiklopedi sains lengkap untuk anak usia 6-15 tahun.','rentable'=>true,'sellable'=>true,'img'=>'https://picsum.photos/id/8/500/400'],
            // RoboKids SBY
            ['shop_idx'=>2,'cat'=>'Robotika','name'=>'mBot STEM Robot Kit','price_rent'=>35000,'price_buy'=>900000,'stock'=>7,'location'=>'Surabaya','desc'=>'Robot programmable Makeblock mBot, cocok untuk belajar pemrograman Scratch dan Arduino.','rentable'=>true,'sellable'=>true,'img'=>'https://picsum.photos/id/9/500/400'],
            ['shop_idx'=>2,'cat'=>'Mainan Edukatif','name'=>'Puzzle 3D Sistem Tata Surya','price_rent'=>12000,'price_buy'=>180000,'stock'=>15,'location'=>'Surabaya','desc'=>'Puzzle 3D edukatif sistem tata surya, bisa dirakit menjadi model yang bisa digantung.','rentable'=>true,'sellable'=>true,'img'=>'https://picsum.photos/id/10/500/400'],
            ['shop_idx'=>2,'cat'=>'Elektronik Edukasi','name'=>'Coding Mouse Bee-Bot','price_rent'=>18000,'price_buy'=>420000,'stock'=>10,'location'=>'Surabaya','desc'=>'Robot mouse Bee-Bot untuk belajar konsep dasar coding tanpa layar.','rentable'=>true,'sellable'=>true,'img'=>'https://picsum.photos/id/11/500/400'],
            ['shop_idx'=>2,'cat'=>'Alat Peraga','name'=>'Planetarium Portable Kecil','price_rent'=>50000,'price_buy'=>1200000,'stock'=>4,'location'=>'Surabaya','desc'=>'Proyektor planetarium portabel untuk menampilkan langit berbintang di dalam ruangan.','rentable'=>true,'sellable'=>false,'img'=>'https://picsum.photos/id/12/500/400'],
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
