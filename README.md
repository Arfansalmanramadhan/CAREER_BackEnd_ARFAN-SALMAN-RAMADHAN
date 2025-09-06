# Backend Test - CRUD User & Search API

Proyek ini dibuat untuk memenuhi take home test Backend Developer.  
Menggunakan **Laravel 10**, **MySQL (XAMPP)**, dan **Postman** untuk pengujian API.

---

## 🚀 Fitur
- **Autentikasi**
  - Register
  - Login
  - Logout
- **CRUD User**
  - Create, Read, Update, Delete user
- **Search API (dari data eksternal)**
  - Cari berdasarkan NAMA
  - Cari berdasarkan NIM
  - Cari berdasarkan YMD
- **Security**
  - Semua endpoint search hanya bisa diakses setelah login
- **Dokumentasi API**
  - Postman collection tersedia (`CAREER_BackEnd_ARFAN SALMAN RAMADHAN.postman_collection.json`)
- **Database Backup**
  - Backup tersedia di `takehome.sql`

---

## ⚙️ Teknologi
- Laravel 10
- MySQL (XAMPP)
- PHP 8.2.12
- Composer
- Postman

---

## 📥 Instalasi
* Mengambil kode dari repo dengan cara di bawah ini
```
git clone https://github.com/Arfansalmanramadhan/CAREER_BackEnd_ARFAN-SALMAN-RAMADHAN.git

cd CAREER_BackEnd_ARFAN-SALMAN-RAMADHAN
```
* intall package dengan cara di bawah ini
```
composer install
```
* Package dan alamat database tidak terbawa ke repo dengan cara di bawah ini
```
cp .env.example .env
```
* Untuk mengatur App Key dengan cara di bawah ini 
```
php artisan key:generate
```

*  Import database
- Lewat phpMyAdmin → Import file database/takehome.sql

* (Opsional) Jalankan migration jika ingin membuat ulang database dari awal
```
php artisan migrate
```

* ▶️ Menjalankan Aplikasi

```
php artisan serve 
```



## 📡 Endpoint API
- POST /api/register
- POST /api/login
- POST /api/logout
- GET /api/users
- GET /api/edit/{id}
- PUT /api/update/{id}
- DELETE /api/delete/{id}
- GET /api/getByName?NAMA=Turner Mia
- GET /api/getByNim?NIM=9352078461
- GET /api/getByYmd?YMD=20230405
