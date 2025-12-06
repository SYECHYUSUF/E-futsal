# eFutsal - Sistem Informasi Reservasi Lapangan Futsal

> **Tugas Final - Pemrograman Web A** > Universitas Hasanuddin

Sistem informasi berbasis web untuk reservasi lapangan futsal yang terintegrasi dengan **WhatsApp Gateway** (Fonnte) untuk notifikasi otomatis.

---

## 👥 Anggota Kelompok 11

| Nama | NIM | Peran |
| :--- | :--- | :--- |
| **Dwi Wahyu Ilahi Angka** | **H071241089** | *Lead Developer / Backend* |
| **Moch. Syekh Yusuf M** | **H071241093** | *Frontend / UI Designer* |
| **Muhammad Alif Sakti** | **H071241018** | *System Analyst / Tester* |

---

## 📖 Tentang Aplikasi

**eFutsal** adalah solusi digital untuk mempermudah proses pemesanan lapangan futsal. Aplikasi ini menggantikan sistem pencatatan manual dengan sistem otomatis yang mampu menangani jadwal, perhitungan tarif (termasuk lintas hari), dan konfirmasi pembayaran.

### Fitur Utama:
* **User/Customer:**
    * Cek jadwal ketersediaan lapangan secara *real-time*.
    * Booking lapangan dengan perhitungan harga otomatis.
    * Upload bukti pembayaran.
    * Menerima notifikasi WhatsApp saat booking disetujui/ditolak.
* **Administrator:**
    * Dashboard ringkasan pendapatan dan statistik booking.
    * Manajemen data lapangan (CRUD Foto & Fasilitas).
    * Verifikasi bukti pembayaran (Approve/Reject).
    * Sistem notifikasi otomatis ke Customer via WhatsApp.

---

## 🛠️ Teknologi yang Digunakan

* **Framework:** [Laravel](https://laravel.com/) (MVC Architecture)
* **Database:** MySQL
* **Frontend:** Blade Templates + [Tailwind CSS](https://tailwindcss.com/)
* **Authentication:** Laravel Breeze
* **API Service:** [Fonnte](https://fonnte.com/) (WhatsApp Gateway)

---

## ⚙️ Dokumentasi Teknis & Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di komputer lokal (*Localhost*).

### Prasyarat
* PHP >= 8.2
* Composer
* Node.js & NPM
* MySQL (XAMPP/Laragon)

### Langkah Instalasi

1.  **Clone Repository / Extract File**
    Masuk ke direktori proyek melalui terminal:
    ```bash
    cd efutsal-blade
    ```

2.  **Instalasi Dependensi**
    Install *library* PHP dan aset *frontend*:
    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment (.env)**
    Salin file contoh konfigurasi dan buat file `.env` baru:
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan sesuaikan konfigurasi berikut:
    ```env
    APP_URL=http://localhost:8000
    
    # Database
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=efutsal_blade
    DB_USERNAME=root
    DB_PASSWORD=

    # WhatsApp Gateway (Fonnte)
    FONNTE_TOKEN=masukkan_token_fonnte_disini
    WHATSAPP_ADMIN_NUMBER=08xxxxxxxxxx
    ```

4.  **Generate Key & Database Seeding**
    Generate kunci aplikasi dan jalankan migrasi database beserta data awal (*seeder*):
    ```bash
    php artisan key:generate
    php artisan migrate:fresh --seed
    ```
    *(Command ini akan membuat akun Admin default dan data Lapangan)*

5.  **Setup Storage**
    Agar gambar dapat diakses publik:
    ```bash
    php artisan storage:link
    ```

6.  **Jalankan Aplikasi**
    Buka dua terminal terpisah dan jalankan perintah berikut:
    
    *Terminal 1 (Laravel Server):*
    ```bash
    php artisan serve
    ```
    
    *Terminal 2 (Vite Compiler):*
    ```bash
    npm run dev
    ```

Akses aplikasi di: [http://localhost:8000](http://localhost:8000)

---

## 📘 Dokumentasi Pengguna

### 1. Alur Pelanggan (Customer)
1.  **Registrasi:** Buat akun baru melalui menu *Register*. Pastikan nomor WhatsApp aktif.
2.  **Cari Lapangan:** Pilih menu "Cari Lapangan" untuk melihat opsi lapangan, foto, dan harga.
3.  **Booking:** * Klik "Booking Sekarang".
    * Pilih Tanggal, Jam Mulai, dan Jam Selesai.
    * Klik "Konfirmasi". Status pesanan menjadi *Pending*.
4.  **Pembayaran:**
    * Buka menu "Riwayat Booking".
    * Klik "Detail" pada pesanan.
    * Unggah foto bukti transfer. Status berubah menjadi *Paid*.

### 2. Alur Administrator
1.  **Login Admin:** Gunakan akun admin (Email: `admin@example.com`, Pass: `password`).
2.  **Verifikasi Booking:**
    * Buka menu "Daftar Reservasi".
    * Cek pesanan dengan status *Paid*.
    * Validasi bukti transfer.
    * Klik **Approve** (Setujui) atau **Reject** (Tolak).
3.  **Notifikasi:** * Saat Admin klik *Approve*, sistem otomatis mengirim pesan WhatsApp ke pelanggan berisi detail jadwal main.

---



**Dibuat dengan ❤️ oleh Kelompok 11 - 2025**