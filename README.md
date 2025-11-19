# Panduan Instalasi Proyek Starter-kit

Proyek ini adalah sebuah starter kit yang dapat digunakan untuk memulai pengembangan aplikasi web dengan cepat. Berikut adalah langkah-langkah untuk menginstalasi dan menjalankan proyek ini.

## Prasyarat

Pastikan Anda telah menginstal perangkat lunak berikut di komputer Anda:

- [PHP](https://www.php.net/downloads.php) >= 7.4
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/) dan [npm](https://www.npmjs.com/get-npm)
- [Laravel](https://laravel.com/docs/8.x/installation)

## Langkah Instalasi

1. **Clone repositori ini**
   
   ```bash
   git clone https://github.com/firstudio-labs/starter-kit.git
   cd Starter-kit
   ```

2. **Instal dependensi PHP**
   
   Jalankan perintah berikut untuk menginstal semua dependensi PHP yang diperlukan:
   
   ```bash
   composer install
   ```

3. **Instal dependensi Node.js**
   
   Jalankan perintah berikut untuk menginstal semua dependensi Node.js yang diperlukan:
   
   ```bash
   npm install
   ```

4. **Konfigurasi file lingkungan**
   
   Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi yang diperlukan, seperti pengaturan database.
   
   ```bash
   cp .env.example .env
   ```

5. **Generate application key**
   
   Jalankan perintah berikut untuk menghasilkan application key:
   
   ```bash
   php artisan key:generate
   ```

6. **Migrasi database**
   
   Jalankan perintah berikut untuk menjalankan migrasi database:
   
   ```bash
   php artisan migrate
   ```

7. **Jalankan server pengembangan**
   
   Jalankan perintah berikut untuk memulai server pengembangan:
   
   ```bash
   php artisan serve
   ```

   Server akan berjalan di `http://localhost:8000`.

## Struktur Direktori

- `app/`: Berisi kode aplikasi utama.
- `resources/views/`: Berisi file tampilan Blade.
- `public/`: Berisi file yang dapat diakses publik seperti CSS, JS, dan gambar.
- `routes/`: Berisi file rute aplikasi.
- `database/`: Berisi migrasi dan seeder database.


## Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).



