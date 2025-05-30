# Dokumentasi Website Portfolio

## Deskripsi

Website portfolio ini adalah sebuah platform yang memungkinkan pengguna untuk menampilkan karya, proyek, dan informasi tentang diri mereka. Website ini dilengkapi dengan sistem manajemen konten yang memungkinkan admin untuk mengelola berbagai bagian website.

## Fitur Utama

1. **Sistem Autentikasi**

   - Login dan Register untuk pengguna
   - Role-based access control (Admin dan User)
   - Manajemen profil pengguna

2. **Halaman Utama**

   - Tampilan hero section dengan informasi utama
   - Framework dan teknologi yang digunakan
   - Label dan deskripsi yang dapat dikustomisasi

3. **Bagian Partner**

   - Galeri partner/klien
   - Manajemen logo partner

4. **Halaman About**

   - Informasi tentang perusahaan/individu
   - Metrik dan statistik
   - Gambar dan teks deskriptif

5. **Timeline**

   - Riwayat dan pencapaian
   - Status dan deskripsi untuk setiap milestone

6. **Portfolio**

   - Galeri karya
   - Detail proyek
   - Deskripsi dan gambar untuk setiap karya

7. **Inspirasi**

   - Galeri inspirasi
   - Manajemen gambar inspirasi

8. **Testimonial**

   - Ulasan dari klien
   - Foto dan informasi klien
   - Pesan testimonial

9. **Kontak**
   - Formulir kontak
   - Manajemen pesan masuk
   - Notifikasi email

## Struktur Database

Database terdiri dari beberapa tabel utama:

- `home`: Konten halaman utama
- `partners`: Data partner/klien
- `about`: Informasi tentang
- `timeline`: Riwayat dan pencapaian
- `works`: Karya portfolio
- `projects`: Proyek-proyek
- `inspiration`: Galeri inspirasi
- `testimonials`: Ulasan klien
- `contacts`: Pesan kontak

## Instalasi

1. Clone repository ini
2. Import database menggunakan file `sql/database.sql`
3. Konfigurasi koneksi database di `config/database.php`
4. Pastikan web server (Apache/Nginx) sudah berjalan
5. Akses website melalui browser

## Struktur Folder

```
├── assets/         # File statis (gambar, font, dll)
├── components/     # Komponen yang dapat digunakan kembali
├── config/         # File konfigurasi
├── dashboard/      # Panel admin
├── js/            # File JavaScript
├── sql/           # File database
├── style/         # File CSS
├── uploads/       # Folder untuk upload file
└── *.php          # File PHP utama
```

## Teknologi yang Digunakan

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript
- Bootstrap (untuk UI)

## Keamanan

- Password di-hash menggunakan algoritma yang aman
- Proteksi terhadap SQL Injection
- Validasi input
- Sanitasi data
- CSRF Protection

## Kontribusi

Silakan buat pull request untuk kontribusi. Untuk perubahan besar, harap buka issue terlebih dahulu untuk mendiskusikan perubahan yang diinginkan.

## Lisensi

[MIT License](LICENSE)
# pt-briannov
