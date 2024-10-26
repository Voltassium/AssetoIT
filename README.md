# AssetoIT
aplikasi Laravel yang dibangun dengan Breeze, Vue, Inertia, dan Filament.

## Prerequisites
Sebelum Anda mulai, pastikan Anda telah memenuhi persyaratan berikut:

- PHP >= 8.0
- Composer
- Node.js >= 14.x
- npm
- Git

## Memulai
Ikuti instruksi ini untuk menyiapkan proyek di komputer lokal Anda.

### 1. Kloning repositori
git clone https://github.com/username-anda/AssetoIT.git
cd AssetoIT

### 2. Instal dependensi PHP
Jalankan perintah berikut untuk menginstal dependensi PHP menggunakan Composer:

composer install

### 3. Siapkan lingkungan
Salin file `.env.example` ke `.env`:

cp .env.example .env

Kemudian, perbarui file `.env` Anda dengan pengaturan database dan aplikasi Anda.

4. Hasilkan kunci aplikasi
Jalankan perintah berikut untuk menghasilkan kunci aplikasi:

```bash
php artisan key:generate
```

### 5. Jalankan migrasi (Opsional)

Jika Anda memiliki migrasi yang ingin dijalankan, Anda dapat melakukannya dengan:

```bash
php artisan migrate
```

### 6. Instal dependensi frontend

Jalankan perintah berikut untuk menginstal dependensi JavaScript:

```bash
npm install
```
atau jika Anda menggunakan Yarn:

```bash
yarn install
```

### 7. Bangun aset frontend

Kompilasi aset Anda dengan:

```bash
npm run dev
```
atau untuk build produksi:

```bash
npm run build
```

### 8. Jalankan server

Anda dapat melayani aplikasi menggunakan server PHP bawaan:

```bash
php artisan serve
```

## Mengakses Aplikasi

Buka browser web Anda dan arahkan ke `http://localhost:8000` untuk mengakses aplikasi.

## Pengujian

Untuk menjalankan tes Anda, gunakan:

```bash
php artisan test
```

## Kontribusi

Kontribusi sangat diterima! Silakan fork repositori dan kirim pull request untuk setiap perbaikan atau fitur.

## Lisensi

Proyek ini dilisensikan di bawah Lisensi MIT - lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.
```

### Catatan
1. Gantilah `username-anda` dan `nama-repo-anda` dengan nama pengguna GitHub dan nama repositori Anda yang sebenarnya.
2. Sesuaikan detail spesifik tentang proyek, seperti langkah tambahan yang mungkin diperlukan untuk pengaturan, konfigurasi tertentu, atau dependensi lain.
3. Tambahkan bagian untuk alat atau pustaka tambahan yang telah Anda sertakan dalam proyek.

Silakan modifikasi template ini agar sesuai dengan kebutuhan proyek Anda!
