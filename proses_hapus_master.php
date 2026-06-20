<?php
include 'koneksi.php';

if (isset($_POST['kode'])) {
    $kode = $_POST['kode'];
    
    $query = "DELETE FROM master_barang_rifan_2430511018 WHERE kode_barang = '$kode'";
    
    if (mysqli_query($koneksi, $query)) {
        echo "Sukses";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>