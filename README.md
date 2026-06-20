# Sistem Informasi Inventaris - Toko Rani Skincare

Aplikasi berbasis web sederhana untuk memantau progres transaksi masuk dan keluar stok barang kosmetik dan skincare secara real-time. Dibuat khusus untuk memenuhi kriteria evaluasi tugas praktikum pemrograman.

## 🌸 Fitur yang Tersedia (Sesuai Kriteria Tugas)

1. **Autentikasi Keamanan (PHP Session):** Halaman login terpisah yang dilindungi dengan _Session_ PHP. Pengguna tidak akan bisa mengakses _dashboard_ tanpa login terlebih dahulu.
2. **Koneksi Full-Stack PHP & MySQL:** Data transaksi dapat ditambahkan, ditampilkan, dan dihapus (CRUD) secara dinamis ke database menggunakan AJAX tanpa memuat ulang halaman.
3. **Cetak & Export PDF:** Fitur untuk mencetak detail bukti transaksi menjadi dokumen PDF yang rapi, lengkap dengan tanda tangan digital penanggung jawab.
4. **Fitur Upload Multiple File:** Mendukung unggah banyak file lampiran nota/faktur sekaligus ke dalam server (tersimpan di folder `/uploads`).
5. **Canvas Tanda Tangan Digital:** Implementasi coretan tanda tangan berbasis HTML5 Canvas yang langsung dikonversi menjadi data string Base64 ke dalam database.
6. **DataTables Plugin:** Tabel interaktif dengan fitur pencarian produk, sortir kolom otomatis, dan pembagian halaman (_pagination_).
7. **Multimedia & Animasi:** Terintegrasi dengan pemutar video YouTube untuk panduan sistem, efek suara (audio) saat transaksi berhasil disimpan, dan animasi transisi halus via CSS.

## 📁 Struktur File & Direktori Proyek

- `index.php` — Halaman utama aplikasi (_Dashboard_, Tabel Inventaris, Modal Input).
- `login.php` — Halaman antarmuka masuk admin.
- `logout.php` — Skrip untuk menghancurkan _session_ dan keluar aplikasi.
- `koneksi.php` — Skrip konfigurasi _database_ MySQL.
- `proses_simpan.php` — Skrip _back-end_ untuk mengelola input teks, _upload_ file multiformat, dan data Base64 TTD.
- `proses_hapus.php` — Skrip _back-end_ untuk menghapus _record_ di _database_.
- `cetak.php` — Halaman _layout_ khusus untuk ekspor/cetak laporan PDF per transaksi.
- `/uploads/` — Direktori tempat bersarangnya file gambar/PDF lampiran faktur.

## ⚙️ Cara Menjalankan Proyek di Localhost

1. Pastikan _local server_ (Laragon atau XAMPP) sudah dalam keadaan **Start** (Apache & MySQL).
2. Buat database baru bernama `inventaris_skincare` di phpMyAdmin, lalu buat tabel bernama `stok_barang`.
3. Pindahkan seluruh file proyek ini beserta folder kosong `uploads` ke dalam folder `www` (Laragon) atau `htdocs` (XAMPP).
4. Buka browser dan akses halaman melalui `http://localhost/[nama_folder_proyek]`.
5. Untuk masuk ke sistem, gunakan kredensial bawaan:
   - **Username:** `admin`
   - **Password:** `admin`
