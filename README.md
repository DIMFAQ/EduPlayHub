# 🎓 EduPlayHub Backend

**Platform e-commerce untuk rental & pembelian alat mahasiswa**

REST API backend dibangun dengan **Laravel 11** dan **MySQL**, menyediakan sistem checkout dan pembayaran QRIS yang simulasi untuk keperluan demo.

---

## 📋 Fitur Utama

✅ **Sistem Checkout**
- Tambah produk ke pesanan
- Auto validasi stok
- Perhitungan harga otomatis
- Status tracking: pending → paid

✅ **Pembayaran QRIS (Simulasi)**
- Generate QRIS code dummy
- Upload bukti pembayaran (image)
- Admin verifikasi pembayaran
- Update status order otomatis

✅ **Database Terstruktur**
- Tabel: `produk`, `pesanan`, `item_pesanan`, `pembayaran`, `users`
- Relasi Eloquent lengkap
- Foreign key constraints

✅ **API RESTful**
- 6 endpoint siap pakai
- Input validation lengkap
- Error handling
- JSON response

---

## 🛠️ Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| Backend Framework | Laravel 11 |
| Database | MySQL 8.0+ |
| Language | PHP 8.2+ |
| Language | PHP 8.2+ |
| API Format | RESTful JSON |
| Version Control | Git |

---

## 🚀 Quick Start

### Prerequisites
```
- PHP 8.2+
- MySQL 8.0+ (running)
- Composer
- Git
```

### Installation

1. **Clone repository**
```bash
git clone https://github.com/DIMFAQ/EduPlayHub.git
cd EduPlayHub
```

2. **Install dependencies**
```bash
composer install
```

3. **Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure database** (edit `.env`)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eduplayhub
DB_USERNAME=root
DB_PASSWORD=
```

5. **Run migration & seed**
```bash
php artisan migrate --fresh --seed
```

6. **Create storage link**
```bash
php artisan storage:link
```

7. **Start server**
```bash
php artisan serve
```

Server running di: **http://localhost:8000**

---

## 📚 API Endpoints

### 🛍️ CHECKOUT
```
POST /api/checkout              → Create pesanan baru
GET /api/checkout/{id}          → Get detail pesanan
```

### 💳 PAYMENT
```
GET /api/payment/{id}           → Get QRIS info
POST /api/payment/upload        → Upload bukti pembayaran
POST /api/payment/verify        → [ADMIN] Verifikasi pembayaran
GET /api/payment/pending-verifs → [ADMIN] List pending payments
```

---

## 📖 Example Request/Response

### 1. Checkout
```bash
POST /api/checkout
Content-Type: application/json

{
  "user_id": 1,
  "items": [
    {"product_id": 1, "quantity": 1},
    {"product_id": 2, "quantity": 2}
  ]
}
```

**Response (201):**
```json
{
  "message": "Checkout berhasil",
  "order": {
    "id": 1,
    "user_id": 1,
    "total_price": "25000000.00",
    "status": "pending",
    "itemPesanan": [...],
    "pembayaran": {...}
  }
}
```

### 2. Get Payment Info
```bash
GET /api/payment/1
```

**Response (200):**
```json
{
  "order_id": 1,
  "amount": "25000000.00",
  "payment_status": "pending",
  "qris_code": "000201263600...",
  "qris_image_url": "https://api.qrserver.com/...",
  "instructions": "Gunakan aplikasi e-wallet untuk memindai QRIS"
}
```

### 3. Upload Proof
```bash
POST /api/payment/upload
Content-Type: multipart/form-data

Form Data:
- order_id: 1
- proof_image: [screenshot.jpg]
```

**Response (200):**
```json
{
  "message": "Bukti pembayaran berhasil diupload",
  "image_url": "http://localhost:8000/storage/payment_proofs/..."
}
```

---

## 🗄️ Database Schema

### Tabel Structure

**produk** (produk)
```
id, name, description, price, stock, image_url, type, timestamps
```

**pesanan** (orders)
```
id, user_id (FK), total_price, status, timestamps
```

**item_pesanan** (order_items)
```
id, pesanan_id (FK), produk_id (FK), quantity, unit_price, subtotal, timestamps
```

**pembayaran** (payments)
```
id, pesanan_id (FK), amount, status, proof_image_path, qris_code, verified_at, timestamps
```

---

## 📁 Project Structure

```
eduplay-backend/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── CheckoutController.php
│   │       └── PaymentController.php
│   └── Models/
│       ├── Product.php
│       ├── Order.php
│       ├── OrderItem.php
│       ├── Payment.php
│       └── User.php
│
├── database/
│   ├── migrations/
│   │   ├── ...create_produk_table.php
│   │   ├── ...create_pesanan_table.php
│   │   ├── ...create_item_pesanan_table.php
│   │   └── ...create_pembayaran_table.php
│   └── seeders/
│       ├── ProductSeeder.php
│       └── DatabaseSeeder.php
│
├── routes/
│   └── api.php
│
├── SETUP_GUIDE.md              → Setup lengkap
├── API_RESPONSE_EXAMPLES.md     → Contoh response
├── EduPlayHub_API.postman_collection.json
└── README.md
```

---

## 🧪 Testing dengan Postman

**Import collection:**
1. Buka Postman
2. Click `Import` → pilih file `EduPlayHub_API.postman_collection.json`
3. Semua endpoint sudah tersedia

**Test User (seed):**
- ID: 1
- Email: test@example.com
- Password: password

**Test Products:** 8 produk sudah tersedia (Laptop, Projector, Printer, dll)

---

## 📋 Test Flow (Demo)

```
1. POST /api/checkout
   ↓ Buat pesanan baru
   
2. GET /api/payment/{order_id}
   ↓ Terima QRIS code

3. POST /api/payment/upload
   ↓ Upload bukti pembayaran (image)

4. POST /api/payment/verify [ADMIN]
   ↓ Verifikasi pembayaran

5. GET /api/checkout/{order_id}
   ↓ Lihat order status = "paid" ✅
```

---

## 🔑 Key Features

| Fitur | Deskripsi |
|-------|-----------|
| **Validation** | Input validation lengkap di semua endpoint |
| **Error Handling** | Custom error response dengan HTTP status |
| **Stock Management** | Auto decrement saat checkout |
| **Eloquent ORM** | Relasi model lengkap (hasMany, belongsTo, hasOne) |
| **Transaction** | Database transaction untuk checkout |
| **File Upload** | Simpan bukti pembayaran di storage |
| **QRIS Simulasi** | Generate QRIS code & QR image dummy |

---

## 🐛 Troubleshooting

| Masalah | Solusi |
|--------|--------|
| **"Table doesn't exist"** | `php artisan migrate:fresh --seed` |
| **"vendor not found"** | `composer install` |
| **"Permission denied"** | `chmod -R 755 storage` |
| **"APP_KEY missing"** | `php artisan key:generate` |
| **"Database connection error"** | Cek `.env` DB config & MySQL running |

---

## 📝 Environment Variables

```env
APP_NAME=EduPlayHub
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eduplayhub
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🚧 Future Improvements

- [ ] Integration Midtrans/Xendit payment gateway
- [ ] Fitur rental (date range & durasi)
- [ ] Authentication (JWT/Sanctum)
- [ ] Admin dashboard
- [ ] Email notifications
- [ ] Unit & integration tests
- [ ] Pagination & search
- [ ] Rate limiting

---

## 📄 Dokumentasi Lengkap

- **[SETUP_GUIDE.md](SETUP_GUIDE.md)** - Setup step-by-step
- **[API_RESPONSE_EXAMPLES.md](API_RESPONSE_EXAMPLES.md)** - Contoh request/response
- **[Laravel Documentation](https://laravel.com/docs)** - Official docs

---

## 👤 Author

**DIMFAQ** (Dimas Faqih)
- Email: dimasfaqih005@gmail.com
- GitHub: [@DIMFAQ](https://github.com/DIMFAQ)

---

## 📄 License

Open source project untuk keperluan akademis.

---

## ✨ Status

🟢 **Production Ready** - Siap untuk demo!

Last Updated: April 20, 2026

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
