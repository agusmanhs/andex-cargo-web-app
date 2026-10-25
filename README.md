# Andex Cargo Modern Web App (Version 2.0)

Aplikasi logistik & ekspedisi kargo modern untuk **PT. Andex Cargo Indonesia**. Dibangun dengan **Laravel 12**, **Filament v3**, **Tailwind CSS**, dan skema database ternormalisasi.

---

## 🚀 Fitur Utama

- **Portal Publik Modern:**
  - Desain *Elevated Glassmorphism Cards* dengan mikro-interaksi dinamis.
  - **Lacak Resi (AWB) Real-time:** Riwayat pelacakan berbasis *vertical timeline*, progress bar tahapan kargo, serta rincian pengirim & penerima.
  - **Kalkulator Cek Tarif Instan:** Perhitungan ongkos kirim otomatis berbasis kota asal, kota tujuan, dan berat timbangan.
  - Direktori 20+ Kantor Cabang & Hub Kargo seluruh Indonesia.
- **Admin Dashboard (Filament v3):**
  - Live metric widgets (Total resi, kiriman dalam proses, terkirim, dan omset cabang).
  - Manajemen Resi / AWB (input resi baru, hitung ongkir, status bayar).
  - Manajemen Manifest Dispatch (muat armada truk, kapal, pesawat antarcabang).
  - Master Data: Kantor Cabang, Layanan Ekspedisi, Pelanggan / Korporat B2B, dan Master Tarif.
  - Manajemen Pengguna Multi-Role (Superadmin, Kepala Cabang, Operator/CS, Kurir).
- **Tool ETL Sinkronisasi Data:**
  - Artisan command `php artisan app:sync-legacy-data` untuk migrasi otomatis data historis dari database lama.

---

## 📦 Kebutuhan Sistem

- PHP >= 8.2 (Mendukung PHP 8.2, 8.3, dan 8.4)
- Composer >= 2.x
- Node.js >= 18.x & NPM
- MySQL >= 8.0 / MariaDB >= 10.4

---

## 🛠️ Panduan Instalasi Lokal

1. **Clone repository:**
   ```bash
   git clone https://github.com/agusmanhs/andex-cargo-web-app.git
   cd andex-cargo-web-app
   ```

2. **Install dependensi PHP & JavaScript:**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Sesuaikan kredensial database di `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=andex_cargo_db
   DB_USERNAME=kargo_andex
   DB_PASSWORD=your_password
   ```

4. **Jalankan Migrasi Database:**
   ```bash
   php artisan migrate
   ```

5. **(Opsional) Sinkronkan Data dari Database Lama:**
   ```bash
   php artisan app:sync-legacy-data --shipments-limit=500
   ```

6. **Build Asset & Jalankan Server:**
   ```bash
   npm run build
   php artisan serve
   ```
   Akses di browser:
   - Portal Publik: `http://localhost:8000`
   - Admin Panel: `http://localhost:8000/admin` (Akun default: `admin@andexcargo.id` / `password123`)

---

## 📄 Lisensi
Hak Cipta &copy; 2026 PT. Andex Cargo Indonesia. Seluruh hak cipta dilindungi undang-undang.
