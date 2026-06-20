# Sistem Informasi Inventaris - Toko Rani Skincare

Aplikasi berbasis web berkonsep *Modern Dashboard* untuk memantau progres transaksi masuk dan keluar stok barang kosmetik dan skincare secara *real-time*. Dibuat khusus untuk memenuhi kriteria evaluasi tugas praktikum pemrograman web berbasis CRUD.

## 🌟 Pembaruan & Fitur Utama (Versi Terbaru)

1. **Logika Master Data & Transaksi (Relasional):** Sistem kini dipisah menjadi dua entitas, yaitu "Master Barang" (sebagai wadah stok murni) dan "Riwayat Transaksi" (sebagai log arus barang masuk/keluar).
2. **Sinkronisasi Stok Real-Time (Otomatis):** Fitur kalkulasi cerdas di *back-end*. Ketika ada pencatatan, pengeditan, atau penghapusan pada Riwayat Transaksi, jumlah stok pada Master Barang akan otomatis terhitung ulang dan ter-*rollback* secara presisi.
3. **UI/UX Modern & Responsif:** Desain antarmuka dirombak menggunakan sistem Grid Bootstrap 5 dan *Tab Pills* (seperti *Single Page Application*). Tata letak dijamin tetap rapi, fleksibel, dan anti-*stuck* saat dibuka via layar HP maupun tablet.
4. **Local Storage Memory:** *Browser* dapat mengingat posisi tab terakhir yang diakses pengguna (Master atau Transaksi) sehingga halaman tidak melompat-lompat setelah *refresh*.
5. **Autentikasi Keamanan:** Halaman *login* terpisah yang dilindungi dengan *Session* PHP.
6. **Cetak Nota & Export PDF:** Fitur pencetakan detail bukti transaksi (Faktur) lengkap dengan tanda tangan digital penanggung jawab.
7. **Tanda Tangan Digital Anti-Scroll:** Implementasi coretan *HTML5 Canvas* yang dioptimalkan untuk sentuhan (*touch screen*) di HP dan dikonversi menjadi data string Base64 ke dalam *database*.
8. **Upload Multiple File:** Mendukung unggah banyak file lampiran nota sekaligus ke dalam server (tersimpan di folder `/uploads`).
9. **DataTables Plugin:** Tabel interaktif dengan fitur pencarian, sortir kolom, dan pembagian halaman (*pagination*).

## 📁 Struktur File & Direktori Proyek

- `index.php` — Halaman utama (Dashboard, Tabel Master, Tabel Transaksi, Modal).
- `login.php` — Halaman antarmuka masuk admin.
- `logout.php` — Skrip untuk menghancurkan _session_ dan keluar aplikasi.
- `koneksi.php` — Skrip konfigurasi kredensial _database_ server.
- `proses_simpan.php` — Skrip _back-end_ simpan & edit transaksi (serta sinkronisasi stok otomatis).
- `proses_hapus.php` — Skrip _back-end_ hapus transaksi (serta *rollback* stok).
- `proses_simpan_master.php` — Skrip _back-end_ untuk mendaftarkan dan mengedit data produk di Master Barang.
- `proses_hapus_master.php` — Skrip _back-end_ untuk menghapus daftar produk.
- `cetak.php` — Halaman _layout_ khusus untuk ekspor laporan nota transaksi.
- `/uploads/` — Direktori tempat bersarangnya file lampiran dokumen/gambar.

## 🗄️ Struktur Database (MySQL)

Sistem ini membutuhkan dua tabel yang saling terhubung:
1. `master_barang_rifan_2430511018` (Menyimpan `kode_barang`, `nama_produk`, `kategori`, dan `stok_sekarang`)
2. `stok_barang_rifan_2430511018` (Menyimpan histori `id`, `kode_barang`, jumlah transaksi, `tipe_transaksi`, TTD digital, dll)

## 🚀 Panduan Deployment ke Hosting (cPanel / CoreFTP)

Bagi keperluan penilaian tugas, sistem ini siap diunggah ke server *live* melalui FTP:
1. Siapkan database di phpMyAdmin server *hosting*, lalu eksekusi struktur SQL untuk kedua tabel di atas.
2. Buka file `koneksi.php`, sesuaikan parameter `$user`, `$pass`, dan `$db` dengan kredensial server *hosting*.
3. Buka **CoreFTP**, lakukan koneksi ke *Site Manager* kampus.
4. Masuk ke direktori `public_html` ➔ `folder_kelas` ➔ `folder_nim_anda`.
5. Blok seluruh file `.php` dan folder `uploads`, lalu klik kanan dan pilih **Upload**.
6. Aplikasi sudah *live* dan bisa diakses via URL untuk diserahkan pelaporannya.
