# SETUP & DEPLOYMENT GUIDE - EduPlayHub Backend

## 📋 Prerequisite
- PHP 8.2+
- MySQL 8.0+
- Composer
- Database sudah berjalan di `127.0.0.1:3306`

## 🚀 QUICK START

### 1. Generate App Key
```bash
php artisan key:generate
```

### 2. Run Migration
```bash
php artisan migrate
```

### 3. Seed Database (Create Test User & Products)
```bash
php artisan db:seed
```

### 4. Create Symbolic Link untuk Storage
```bash
php artisan storage:link
```

### 5. Start Server
```bash
php artisan serve
```

Server akan berjalan di `http://localhost:8000`

---

## 📦 Database Schema

### users
- id, name, email, password, timestamps

### products
- id, name, description, price, stock, image_url, type, timestamps

### orders
- id, user_id (FK), total_price, status, timestamps
- status: pending → paid → completed

### order_items
- id, order_id (FK), product_id (FK), quantity, unit_price, subtotal, timestamps

### payments
- id, order_id (FK), amount, status, proof_image_path, qris_code, verified_at, timestamps
- status: pending → verified

---

## 🔄 API ENDPOINTS

### CHECKOUT
```
POST /api/checkout
GET /api/checkout/{order_id}
```

### PAYMENT
```
GET /api/payment/{order_id}              - Lihat info QRIS
POST /api/payment/upload                 - Upload bukti pembayaran
POST /api/payment/verify                 - [ADMIN] Verifikasi pembayaran
GET /api/payment/pending-verifications   - [ADMIN] Lihat payment menunggu verifikasi
```

---

## 🧪 TESTING - Postman Collection

### Test User
- ID: 1
- Email: test@example.com
- Password: password

### Test Products
Jalankan `php artisan db:seed` untuk lihat semua produk

---

## ✅ FLOW DEMO BESOK

### Customer
1. **POST /api/checkout**
   ```json
   {
     "user_id": 1,
     "items": [
       {"product_id": 1, "quantity": 1},
       {"product_id": 2, "quantity": 2}
     ]
   }
   ```
   Response: `order_id`, `total_price`, `payment status: pending`

2. **GET /api/payment/{order_id}**
   - Terima QRIS code + dummy URL QR image

3. **POST /api/payment/upload**
   ```
   Form Data:
   - order_id: 1
   - proof_image: [file.jpg]
   ```
   Response: `image_url`, `status: pending verifikasi`

### Admin
4. **POST /api/payment/verify**
   ```json
   {
     "order_id": 1
   }
   ```
   Response: `payment_status: verified`, `order_status: paid`

---

## 📁 Project Structure

```
app/Http/Controllers/
├── CheckoutController.php     # Checkout logic
└── PaymentController.php       # Payment logic

app/Models/
├── Product.php
├── Order.php
├── OrderItem.php
├── Payment.php
└── User.php

database/
├── migrations/                 # All 5 table migrations
└── seeders/
    ├── ProductSeeder.php       # 8 test products
    └── DatabaseSeeder.php

routes/
└── api.php                     # All API routes
```

---

## ⚠️ NOTES

- **Payment Simulasi**: QRIS code dummy, bukan real Midtrans/Xendit
- **Image Upload**: Simpan di `storage/app/public/payment_proofs/order_{id}`
- **Stok Management**: Otomatis berkurang saat checkout
- **Relasi Eloquent**: Sudah setup, bisa langsung `.load()` atau `.with()`

## 🐛 TROUBLESHOOTING

### "Table doesn't exist"
```bash
php artisan migrate --fresh
```

### "Permission denied" (Storage)
```bash
chmod -R 755 storage
php artisan storage:link
```

### APP_KEY missing
```bash
php artisan key:generate
```

---

## 📝 NEXT STEPS (Post-Demo)
- [ ] Integration Midtrans/Xendit
- [ ] Fitur rental (date range, durasi)
- [ ] Auth middleware (login/register)
- [ ] Admin dashboard
- [ ] Email notification
- [ ] Unit tests

---

**Status**: ✅ Ready to demo!
