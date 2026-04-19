<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop Dell XPS 13',
                'description' => 'Laptop powerful untuk mahasiswa teknik',
                'price' => 15000000,
                'stock' => 5,
                'type' => 'purchase',
            ],
            [
                'name' => 'Projector EPSON EB-X05',
                'description' => 'Projector untuk presentasi dan diskusi',
                'price' => 5000000,
                'stock' => 10,
                'type' => 'purchase',
            ],
            [
                'name' => 'Printer Canon PIXMA',
                'description' => 'Printer multifungsi berwarna',
                'price' => 2500000,
                'stock' => 8,
                'type' => 'purchase',
            ],
            [
                'name' => 'Kamera DSLR Canon EOS R50',
                'description' => 'Kamera profesional untuk dokumentasi',
                'price' => 8000000,
                'stock' => 3,
                'type' => 'purchase',
            ],
            [
                'name' => 'Microphone Condenser Blue Yeti',
                'description' => 'Microphone untuk recording dan streaming',
                'price' => 1500000,
                'stock' => 15,
                'type' => 'purchase',
            ],
            [
                'name' => 'Monitor 4K LG UltraFine 32"',
                'description' => 'Monitor resolusi tinggi untuk design',
                'price' => 6000000,
                'stock' => 4,
                'type' => 'purchase',
            ],
            [
                'name' => 'Keyboard Mechanical Corsair K95',
                'description' => 'Keyboard gaming dengan switch mechanical',
                'price' => 2000000,
                'stock' => 20,
                'type' => 'purchase',
            ],
            [
                'name' => 'Mouse Logitech MX Master 3',
                'description' => 'Mouse profesional untuk produktivitas',
                'price' => 1200000,
                'stock' => 12,
                'type' => 'purchase',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
