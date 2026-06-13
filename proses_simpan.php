<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipe = $_POST['tipeTransaksi'];
    $kode = $_POST['kodeBarang'];
    $nama = $_POST['namaProduk'];
    $kategori = $_POST['kategoriProduk'];
    $jumlah = $_POST['jumlahBarang'];
    
    // 1. Proses Tanda Tangan (Canvas Base64)
    $ttd_digital = "";
    if (isset($_POST['ttd_digital']) && !empty($_POST['ttd_digital'])) {
        $ttd_digital = $_POST['ttd_digital']; // Simpan string base64-nya langsung ke database
    }

    // 2. Proses Upload Multiple File
    $nama_file_gabungan = "";
    if (isset($_FILES['fileFaktur'])) {
        $file_array = [];
        $total_file = count($_FILES['fileFaktur']['name']);
        
        for ($i = 0; $i < $total_file; $i++) {
            $nama_file = $_FILES['fileFaktur']['name'][$i];
            $tmp_file = $_FILES['fileFaktur']['tmp_name'][$i];
            
            if ($nama_file != "") {
                // Pindahkan file ke folder uploads
                move_uploaded_file($tmp_file, "uploads/" . $nama_file);
                $file_array[] = $nama_file;
            }
        }
        // Gabungkan nama file dengan koma jika ada banyak
        $nama_file_gabungan = implode(",", $file_array);
    }
    
    // 3. Query Simpan ke Database
    $query = "INSERT INTO stok_barang (kode_barang, nama_produk, kategori, jumlah, tipe_transaksi, file_faktur, ttd_digital) 
              VALUES ('$kode', '$nama', '$kategori', '$jumlah', '$tipe', '$nama_file_gabungan', '$ttd_digital')";
              
    if (mysqli_query($koneksi, $query)) {
        echo "Sukses";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>