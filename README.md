# 📦 Inventory API

Inventory API adalah RESTful API berbasis Laravel yang dirancang untuk mengelola data user, produk, lokasi, kategori, serta mutasi barang. Proyek ini dikembangkan sebagai bagian dari tes seleksi Backend Developer di ID-Grow (PT. Clavata Extra Sukses).

---

## 🚀 Fitur Utama

- Autentikasi menggunakan Bearer Token (Laravel Sanctum)
- CRUD untuk User, Produk, Lokasi, Kategori, dan Mutasi
- Relasi many-to-many antara Produk dan Lokasi dengan data stok pada tabel pivot
- Mutasi keluar/masuk otomatis menambah/mengurangi stok
- Riwayat mutasi berdasarkan Produk dan User
- Output data berupa JSON
- Dokumentasi API menggunakan Postman
- Deployable dengan Docker melalui Dockerfile

---

## 🧾 Teknologi

- Laravel 12
- PHP 8.2
- MySQL
- Docker (tanpa Docker Compose)
- Postman

---

## ⚙️ Cara Instalasi & Menjalankan Proyek



## 📄 Dokumentasi API (Postman)

Link dokumentasi Postman:
[📬 Klik di sini untuk melihat dokumentasi](https://documenter.getpostman.com/view/26396459/2sB34fkfZa)

