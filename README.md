# Inventory API

Inventory API adalah RESTful API berbasis Laravel yang dirancang untuk mengelola data user, produk, lokasi, kategori, serta mutasi barang. Proyek ini dikembangkan sebagai bagian dari tes seleksi Backend Developer di ID-Grow (PT. Clavata Extra Sukses).

---

## Fitur Utama

- Autentikasi menggunakan Bearer Token (Laravel Sanctum)
- CRUD untuk User, Produk, Lokasi, Kategori, dan Mutasi
- Relasi many-to-many antara Produk dan Lokasi dengan data stok pada tabel pivot
- Mutasi keluar/masuk otomatis menambah/mengurangi stok
- Riwayat mutasi berdasarkan Produk dan User
- Output data berupa JSON
- Dokumentasi API menggunakan Postman
- Deployable dengan Docker melalui Dockerfile

---

## Teknologi

- Laravel 12
- PHP 8.2
- MySQL
- Docker (tanpa Docker Compose)
- Postman

---

## Cara Instalasi & Menjalankan Proyek

### 🔹 Opsi 1: Tanpa Docker (Lokal)
1. Clone repo dan masuk ke folder:
   ```bash
   git clone https://github.com/yusufsetiya/idgrow-backend-test.git
   cd idgrow-backend-test
   ```
2. Rename `.env.example` menjadi `.env` dan edit konfigurasi database sesuai database lokal:
   ```env
   DB_HOST=127.0.0.1
   DB_DATABASE=inventory_api
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Jalankan perintah berikut:
   ```bash
   composer install
   php artisan key:generate
   php artisan migrate --seed
   php artisan serve
   ```

### 🔹 Opsi 2: Dengan Docker
1. Clone repo dan masuk ke folder:
   ```bash
   git clone https://github.com/yusufsetiya/idgrow-backend-test.git
   cd idgrow-backend-test
   ```
2. Ubah konfigurasi database di `.env.example` sesuai dengan database online yang anda punya:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=
   DB_PORT=
   DB_DATABASE=
   DB_USERNAME= 
   DB_PASSWORD=
   ```
3. Build dan jalankan container:
   ```bash
   docker build -t inventory-api .
   docker run -p 8000:8000 inventory-api
   ```
4. API dapat diakses di `http://{ip-server-anda}:8000`:

## Dokumentasi API (Postman)

Link dokumentasi Postman:
[📬 Klik di sini untuk melihat dokumentasi](https://documenter.getpostman.com/view/26396459/2sB34fkfZa)

