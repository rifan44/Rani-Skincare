<?php
session_start();
if (!isset($_SESSION['login'])) {
    die("Akses ditolak. Silakan login terlebih dahulu.");
}

include 'koneksi.php';

if (!isset($_GET['id'])) {
    die("ID Transaksi tidak ditemukan.");
}

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM stok_barang_rifan_2430511018 WHERE id = '$id'");
$data = mysqli_fetch_array($query);

if (!$data) {
    die("Data transaksi tidak ada di database.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Transaksi #<?= $data['id']; ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Arial, sans-serif; color: #333; margin: 30px; }
        .nota-box { max-width: 600px; margin: auto; border: 1px solid #ddd; padding: 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #ff66a3; padding-bottom: 15px; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #ff66a3; }
        .header p { margin: 5px 0 0 0; font-size: 14px; color: #777; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table td { padding: 10px 5px; border-bottom: 1px solid #eee; }
        table td.label { font-weight: bold; color: #555; width: 40%; }
        .ttd-section { margin-top: 30px; text-align: right; }
        .ttd-space { margin-top: 10px; }
        .ttd-img { border: 1px dashed #ccc; border-radius: 4px; background: #fff; width: 150px; height: 60px; }
        .btn-print { background: #ff66a3; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; margin-bottom: 15px; }
        
        @media print {
            .btn-print { display: none; }
            body { margin: 0; }
            .nota-box { border: none; box-shadow: none; padding: 0; }
        }
    </style>
</head>
<body>

    <div style="text-align: center;">
        <button class="btn-print" onclick="window.print()">📥 Simpan Sebagai PDF / Cetak</button>
    </div>

    <div class="nota-box">
        <div class="header">
            <h2>🌸 RANI SKINCARE</h2>
            <p>Bukti Dokumen Riwayat Transaksi Inventaris Stok</p>
        </div>

        <table>
            <tr>
                <td class="label">ID Dokumen</td>
                <td>#TRX-00<?= $data['id']; ?></td>
            </tr>
            <tr>
                <td class="label">Tipe Transaksi</td>
                <td><strong><?= $data['tipe_transaksi'] == 'Masuk' ? 'Barang Masuk (+)' : 'Barang Keluar (-)'; ?></strong></td>
            </tr>
            <tr>
                <td class="label">Kode Barang</td>
                <td><?= $data['kode_barang']; ?></td>
            </tr>
            <tr>
                <td class="label">Nama Produk</td>
                <td><?= $data['nama_produk']; ?></td>
            </tr>
            <tr>
                <td class="label">Kategori Produk</td>
                <td><?= $data['kategori']; ?></td>
            </tr>
            <tr>
                <td class="label">Jumlah Kuantitas</td>
                <td><?= $data['jumlah']; ?> pcs</td>
            </tr>
            <tr>
                <td class="label">Berkas Lampiran</td>
                <td><?= $data['file_faktur'] ? $data['file_faktur'] : 'Tidak ada berkas faktur'; ?></td>
            </tr>
        </table>

        <div class="ttd-section">
            <p>Penanggung Jawab,</p>
            <div class="ttd-space">
                <?php if(!empty($data['ttd_digital'])): ?>
                    <img class="ttd-img" src="<?= $data['ttd_digital']; ?>" alt="Tanda Tangan">
                <?php else: ?>
                    <div style="height: 60px; color: #aaa; font-style: italic; font-size: 12px; line-height: 60px; text-align: center;">(Tanpa Tanda Tangan)</div>
                <?php endif; ?>
            </div>
            <p style="margin-top: 5px; font-size: 13px; font-weight: bold; color: #555;">Rani Skincare Admin</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>