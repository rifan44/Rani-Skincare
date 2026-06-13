<?php
include 'koneksi.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    // Query hapus data berdasarkan ID
    $query = "DELETE FROM stok_barang WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        echo "Sukses";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>