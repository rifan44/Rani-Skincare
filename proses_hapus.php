<?php
include 'koneksi.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $res = mysqli_query($koneksi, "SELECT * FROM stok_barang_rifan_2430511018 WHERE id='$id'");
    $data = mysqli_fetch_assoc($res);
    
    if ($data) {
        $kode = $data['kode_barang'];
        $jumlah = (int)$data['jumlah'];
        $tipe = $data['tipe_transaksi'];

        if ($tipe == 'Masuk') {
            mysqli_query($koneksi, "UPDATE master_barang_rifan_2430511018 SET stok_sekarang = stok_sekarang - $jumlah WHERE kode_barang = '$kode'");
        } else {
            mysqli_query($koneksi, "UPDATE master_barang_rifan_2430511018 SET stok_sekarang = stok_sekarang + $jumlah WHERE kode_barang = '$kode'");
        }

        $queryHapus = "DELETE FROM stok_barang_rifan_2430511018 WHERE id = '$id'";
        if (mysqli_query($koneksi, $queryHapus)) {
            echo "Sukses";
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
}
?>