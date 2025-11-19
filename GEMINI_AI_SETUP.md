# Setup Gemini AI untuk Generate Artikel

## Langkah-langkah Setup:

### 1. Dapatkan API Key Gemini
- Kunjungi [Google AI Studio](https://makersuite.google.com/app/apikey)
- Login dengan akun Google
- Klik "Create API Key"
- Copy API key yang dihasilkan

### 2. Konfigurasi Environment Variable
Tambahkan baris berikut ke file `.env` Anda:

```env
# Gemini AI Configuration
GEMINI_API_KEY=your_gemini_api_key_here
```

Ganti `your_gemini_api_key_here` dengan API key yang sudah Anda dapatkan.

### 3. Fitur yang Tersedia

#### Generate Judul Artikel
- Klik tombol "Generate Judul" di halaman create artikel
- Masukkan topik yang diinginkan
- Pilih kategori (opsional)
- AI akan memberikan 5 pilihan judul menarik

#### Generate Isi Artikel
- Isi judul artikel terlebih dahulu
- Pilih kategori (opsional)
- Klik tombol "Generate dengan AI"
- Pilih panjang artikel yang diinginkan (300-1200 kata)
- AI akan membuat konten artikel lengkap

### 4. Keamanan
- API key disimpan dengan aman di environment variable
- Tidak pernah di-hardcode dalam source code
- Dilindungi dengan middleware auth dan role admin
- Request divalidasi sebelum dikirim ke Gemini API

### 5. Best Practices
- Selalu review konten yang dihasilkan AI sebelum publish
- Edit dan customize sesuai kebutuhan
- Pastikan konten sesuai dengan brand voice dan guidelines
- Gunakan sebagai starting point, bukan hasil final

### 6. Troubleshooting

#### Error "Layanan AI tidak tersedia"
- Pastikan GEMINI_API_KEY sudah diset di file .env
- Restart server Laravel setelah menambah environment variable

#### Error "Gagal menghubungi Gemini API"
- Periksa koneksi internet
- Pastikan API key valid dan aktif
- Cek quota API di Google AI Studio

#### Konten tidak sesuai ekspektasi
- Coba ganti judul atau kategori
- Gunakan kata kunci yang lebih spesifik
- Edit manual hasil generate sesuai kebutuhan

### 7. Rate Limits
Gemini API memiliki rate limits:
- Free tier: 15 requests per minute
- Paid tier: limits yang lebih tinggi

Jika mencapai limit, tunggu beberapa menit sebelum mencoba lagi.
