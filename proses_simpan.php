<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? ''; 
    $tipe = $_POST['tipeTransaksi'];
    $kode = $_POST['kodeBarang'];
    $nama = $_POST['namaProduk'];
    $kategori = $_POST['kategoriProduk'];
    $jumlah = (int)$_POST['jumlahBarang'];
    
    $ttd_digital = "";
    if (isset($_POST['ttd_digital']) && !empty($_POST['ttd_digital'])) {
        $ttd_digital = $_POST['ttd_digital'];
    }

    $nama_file_gabungan = "";
    if (isset($_FILES['fileFaktur'])) {
        $file_array = [];
        $total_file = count($_FILES['fileFaktur']['name']);
        for ($i = 0; $i < $total_file; $i++) {
            $nama_file = $_FILES['fileFaktur']['name'][$i];
            $tmp_file = $_FILES['fileFaktur']['tmp_name'][$i];
            if ($nama_file != "") {
                move_uploaded_file($tmp_file, "uploads/" . $nama_file);
                $file_array[] = $nama_file;
            }
        }
        $nama_file_gabungan = implode(",", $file_array);
    }

    if (!empty($id)) {
        $resLama = mysqli_query($koneksi, "SELECT * FROM stok_barang_rifan_2430511018 WHERE id='$id'");
        $dataLama = mysqli_fetch_assoc($resLama);
        $jumlahLama = (int)$dataLama['jumlah'];
        $tipeLama = $dataLama['tipe_transaksi'];
        $kodeLama = $dataLama['kode_barang'];

        if ($tipeLama == 'Masuk') {
            mysqli_query($koneksi, "UPDATE master_barang_rifan_2430511018 SET stok_sekarang = stok_sekarang - $jumlahLama WHERE kode_barang = '$kodeLama'");
        } else {
            mysqli_query($koneksi, "UPDATE master_barang_rifan_2430511018 SET stok_sekarang = stok_sekarang + $jumlahLama WHERE kode_barang = '$kodeLama'");
        }

        $queryUpdate = "UPDATE stok_barang_rifan_2430511018 SET 
                        kode_barang='$kode', nama_produk='$nama', kategori='$kategori', jumlah='$jumlah', tipe_transaksi='$tipe' 
                        WHERE id='$id'";
        
        if (mysqli_query($koneksi, $queryUpdate)) {
            if ($tipe == 'Masuk') {
                mysqli_query($koneksi, "UPDATE master_barang_rifan_2430511018 SET stok_sekarang = stok_sekarang + $jumlah WHERE kode_barang = '$kode'");
            } else {
                mysqli_query($koneksi, "UPDATE master_barang_rifan_2430511018 SET stok_sekarang = stok_sekarang - $jumlah WHERE kode_barang = '$kode'");
            }
            echo "Sukses";
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }

    } else {
        $query = "INSERT INTO stok_barang_rifan_2430511018 (kode_barang, nama_produk, kategori, jumlah, tipe_transaksi, file_faktur, ttd_digital) 
                  VALUES ('$kode', '$nama', '$kategori', '$jumlah', '$tipe', '$nama_file_gabungan', '$ttd_digital')";
                  
        if (mysqli_query($koneksi, $query)) {
            if ($tipe == 'Masuk') {
                mysqli_query($koneksi, "UPDATE master_barang_rifan_2430511018 SET stok_sekarang = stok_sekarang + $jumlah WHERE kode_barang = '$kode'");
            } else {
                mysqli_query($koneksi, "UPDATE master_barang_rifan_2430511018 SET stok_sekarang = stok_sekarang - $jumlah WHERE kode_barang = '$kode'");
            }
            echo "Sukses";
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
}
?>