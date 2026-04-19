# API Response Examples - EduPlayHub

## 1️⃣ CHECKOUT - Create Order

### Request
```
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

### Success Response (201)
```json
{
  "message": "Checkout berhasil",
  "order": {
    "id": 1,
    "user_id": 1,
    "total_price": "25000000.00",
    "status": "pending",
    "created_at": "2025-01-01T10:30:00Z",
    "updated_at": "2025-01-01T10:30:00Z",
    "orderItems": [
      {
        "id": 1,
        "order_id": 1,
        "product_id": 1,
        "quantity": 1,
        "unit_price": "15000000.00",
        "subtotal": "15000000.00",
        "product": {
          "id": 1,
          "name": "Laptop Dell XPS 13",
          "price": "15000000.00"
        }
      },
      {
        "id": 2,
        "order_id": 1,
        "product_id": 2,
        "quantity": 2,
        "unit_price": "5000000.00",
        "subtotal": "10000000.00",
        "product": {
          "id": 2,
          "name": "Projector EPSON EB-X05",
          "price": "5000000.00"
        }
      }
    ],
    "payment": {
      "id": 1,
      "order_id": 1,
      "amount": "25000000.00",
      "status": "pending",
      "proof_image_path": null,
      "qris_code": "00020126360014ID.CO.WEBSTATIC..."
    }
  }
}
```

### Error Response (400) - Stok tidak cukup
```json
{
  "message": "Stok produk tidak cukup untuk: Laptop Dell XPS 13",
  "product": "Laptop Dell XPS 13",
  "available_stock": 2,
  "requested_quantity": 5
}
```

---

## 2️⃣ CHECKOUT - Get Order Detail

### Request
```
GET /api/checkout/1
```

### Response (200)
```json
{
  "id": 1,
  "user_id": 1,
  "total_price": "25000000.00",
  "status": "pending",
  "created_at": "2025-01-01T10:30:00Z",
  "updated_at": "2025-01-01T10:30:00Z",
  "user": {
    "id": 1,
    "name": "Test User",
    "email": "test@example.com"
  },
  "orderItems": [ ... ],
  "payment": { ... }
}
```

---

## 3️⃣ PAYMENT - Get QRIS Info

### Request
```
GET /api/payment/1
```

### Response (200)
```json
{
  "order_id": 1,
  "amount": "25000000.00",
  "order_status": "pending",
  "payment_status": "pending",
  "qris_code": "00020126360014ID.CO.WEBSTATIC01051198010303UME51570010A000000000001234520400005303360406110412345678901520423081810502100063041032500820320000321012312345678901234567890215EduPlay1562290525EEC18001234.1234.0606051040100000000000063047BB5",
  "qris_image_url": "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=00020126360014...",
  "payment_method": "QRIS",
  "instructions": "Gunakan aplikasi e-wallet atau mobile banking Anda untuk memindai kode QRIS di atas"
}
```

---

## 4️⃣ PAYMENT - Upload Bukti Pembayaran

### Request
```
POST /api/payment/upload
Content-Type: multipart/form-data

Form Data:
- order_id: 1
- proof_image: [file: bukti_pembayaran.jpg]
```

### Success Response (200)
```json
{
  "message": "Bukti pembayaran berhasil diupload",
  "payment": {
    "id": 1,
    "order_id": 1,
    "amount": "25000000.00",
    "status": "pending",
    "proof_image_path": "payment_proofs/order_1/bukti_pembayaran.jpg",
    "qris_code": "00020126360014...",
    "verified_at": null,
    "created_at": "2025-01-01T10:30:00Z",
    "updated_at": "2025-01-01T10:35:00Z"
  },
  "image_url": "http://localhost:8000/storage/payment_proofs/order_1/bukti_pembayaran.jpg"
}
```

### Error Response (400) - Payment sudah verified
```json
{
  "message": "Payment sudah verified, tidak bisa upload bukti lagi"
}
```

---

## 5️⃣ PAYMENT - Verify Payment (ADMIN)

### Request
```
POST /api/payment/verify
Content-Type: application/json

{
  "order_id": 1
}
```

### Success Response (200)
```json
{
  "message": "Pembayaran berhasil diverifikasi",
  "payment": {
    "id": 1,
    "order_id": 1,
    "amount": "25000000.00",
    "status": "verified",
    "proof_image_path": "payment_proofs/order_1/bukti_pembayaran.jpg",
    "qris_code": "00020126360014...",
    "verified_at": "2025-01-01T10:40:00Z",
    "created_at": "2025-01-01T10:30:00Z",
    "updated_at": "2025-01-01T10:40:00Z"
  },
  "order_status": "paid"
}
```

### Error Response (400) - Belum ada bukti upload
```json
{
  "message": "Belum ada bukti pembayaran yang diupload"
}
```

---

## 6️⃣ PAYMENT - Get Pending Verifications (ADMIN)

### Request
```
GET /api/payment/pending-verifications
```

### Response (200)
```json
{
  "total": 2,
  "payments": [
    {
      "id": 1,
      "order_id": 1,
      "amount": "25000000.00",
      "status": "pending",
      "proof_image_path": "payment_proofs/order_1/bukti_1.jpg",
      "qris_code": "00020126360014...",
      "verified_at": null,
      "created_at": "2025-01-01T10:30:00Z",
      "updated_at": "2025-01-01T10:35:00Z",
      "order": {
        "id": 1,
        "user_id": 1,
        "total_price": "25000000.00",
        "status": "pending",
        "user": {
          "id": 1,
          "name": "Test User",
          "email": "test@example.com"
        }
      }
    },
    {
      "id": 2,
      "order_id": 2,
      "amount": "3700000.00",
      "status": "pending",
      "proof_image_path": "payment_proofs/order_2/bukti_2.jpg",
      ...
    }
  ]
}
```

---

## ❌ Error Responses

### 400 - Bad Request (Validation Error)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "user_id": ["The user_id field is required."],
    "items": ["The items field is required."]
  }
}
```

### 404 - Not Found
```json
{
  "message": "No query results found for model..."
}
```

### 500 - Server Error
```json
{
  "message": "Checkout gagal",
  "error": "Exception message..."
}
```

---

## 📌 TESTING TIPS

1. **Selalu gunakan user_id yang ada** (`POST /api/users` untuk create user baru)
2. **Product ID harus valid**, gunakan product dari seeding
3. **Order ID untuk payment harus dari checkout yang berhasil**
4. **Stok berkurang otomatis saat checkout**
5. **File upload max 5MB**, format: JPEG, PNG, JPG, GIF
6. **QRIS code adalah dummy saja**, bukan real payment gateway

---

## 🔄 DEMO WORKFLOW

```
1. POST /api/checkout → dapatkan order_id ✅
   ↓
2. GET /api/payment/{order_id} → terima QRIS ✅
   ↓
3. POST /api/payment/upload → upload bukti (image) ✅
   ↓
4. POST /api/payment/verify → admin verifikasi ✅
   ↓
5. GET /api/checkout/{order_id} → lihat order status = "paid" ✅
```

---

Status: ✅ Semua endpoint siap ditest!
