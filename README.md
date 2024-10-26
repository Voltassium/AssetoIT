# AssetoIT 

Ini adalah aplikasi Laravel yang dibangun dengan Breeze, Vue, Inertia, dan Filament.

## Prerequisites
Sebelum Anda mulai, pastikan Anda telah memenuhi persyaratan berikut:

- PHP >= 8.0
- Composer
- Node.js >= 14.x
- npm atau Yarn
- Git

## Memulai
Ikuti instruksi ini untuk menyiapkan proyek di mesin lokal Anda.

### 1. Kloning repositori

dengan menggunakan command dibawah
```bash
git clone https://github.com/Voltassium/AssetoIT.git
cd AssetoIT
```

atau download Github Desktop

### 2. Instal dependensi PHP

Jalankan perintah berikut untuk menginstal dependensi PHP menggunakan Composer:

```bash
composer install
```

### 3. Siapkan lingkungan

Salin file `.env.example` ke `.env`:

```bash
cp .env.example .env
```

Kemudian, perbarui file `.env` Anda dengan pengaturan database dan aplikasi Anda.

### 4. Hasilkan kunci aplikasi

Jalankan perintah berikut untuk menghasilkan kunci aplikasi:

```bash
php artisan key:generate
```

### 5. Jalankan migrasi

Jika Anda memiliki migrasi yang ingin dijalankan, Anda dapat melakukannya dengan:

```bash
php artisan migrate
```

### 6. Install dependensi frontend

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
