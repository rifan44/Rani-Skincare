# Sistem Informasi Inventaris - Toko Rani Skincare

Aplikasi berbasis web sederhana untuk memantau progres transaksi masuk dan keluar stok barang kosmetik dan skincare secara real-time. Dibuat khusus untuk memenuhi kriteria evaluasi tugas praktikum pemrograman.

## 🌸 Fitur yang Tersedia (Sesuai Kriteria Tugas)
1. **Autentikasi Login Antarmuka:** Pembatasan halaman dashboard menggunakan form login interaktif.
2. **Koneksi Full-Stack PHP & MySQL:** Data transaksi tersimpan dan terhapus secara dinamis dari database.
3. **Fitur Upload Multiple File:** Mendukung unggah banyak file lampiran nota/faktur sekaligus ke dalam server (`/uploads`).
4. **Canvas Tanda Tangan Digital:** Implementasi coretan tanda tangan penanggung jawab berbasis HTML5 Canvas yang dikonversi menjadi data string Base64 langsung ke database.
5. **DataTables Plugin:** Pencarian data produk, sortir otomatis, dan pembagian halaman (pagination) yang responsif.
6. **Multimedia & Animasi:** Efek suara (audio) sukses saat penyimpanan transaksi, video panduan sistem bawaan, dan animasi kelancaran UI via CSS.

## 🛠️ Alat & Pustaka (Tech Stack)
* **Sisi Klien (Front-End):** HTML5, CSS3, Bootstrap 5, jQuery, DataTables Plugin.
* **Sisi Server (Back-End):** PHP Native, MySQL Database.

## ⚙️ Cara Menjalankan Proyek Lokal
1. Pastikan server lokal seperti Laragon atau XAMPP sudah aktif.
2. Import file database atau buat database bernama `inventaris_skincare` dan buat tabel `stok_barang`.
3. Pindahkan seluruh file proyek ke folder `www` atau `htdocs`.
4. Buka browser dan akses halaman melalui `localhost/[nama_folder_proyek]`.