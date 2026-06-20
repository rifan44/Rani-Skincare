<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_lama = $_POST['editKodeLama'] ?? '';
    $kode = $_POST['kode_barang'];
    $nama = $_POST['nama_produk'];
    $kategori = $_POST['kategori'];
    $stok = (int)$_POST['stok_sekarang'];

    if (!empty($kode_lama)) {
        $query = "UPDATE master_barang_rifan_2430511018 
                  SET nama_produk='$nama', kategori='$kategori', stok_sekarang='$stok' 
                  WHERE kode_barang='$kode_lama'";
    } else {
        $query = "INSERT INTO master_barang_rifan_2430511018 (kode_barang, nama_produk, kategori, stok_sekarang) 
                  VALUES ('$kode', '$nama', '$kategori', '$stok')";
    }

    if (mysqli_query($koneksi, $query)) {
        echo "Sukses";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>