<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// Menarik data Master Barang
$data_master = [];
$query_master = mysqli_query($koneksi, "SELECT * FROM master_barang_rifan_2430511018");
if($query_master) {
    while($row = mysqli_fetch_assoc($query_master)) {
        $data_master[] = $row;
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventaris - Toko Rani Skincare</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />

    <style>
        :root {
            --rani-pink: #ff66a3;
            --rani-dark: #e65590;
            --rani-light: #fff0f5;
            --bg-color: #f4f7f6;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Poppins', sans-serif;
            color: #333;
            overflow-x: hidden;
        }

        .top-navbar {
            background: linear-gradient(135deg, var(--rani-pink), var(--rani-dark));
            padding: 15px 0;
            box-shadow: 0 4px 15px rgba(255, 102, 163, 0.2);
        }
        .top-navbar .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
        }

        .card-rani {
            border: none;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.04);
            background: #fff;
        }
        .card-header-custom {
            background-color: transparent;
            border-bottom: 2px solid var(--rani-light);
            padding: 20px;
        }

        .btn-rani {
            background-color: var(--rani-pink);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-rani:hover {
            background-color: var(--rani-dark);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(230, 85, 144, 0.3);
        }

        .nav-pills .nav-link {
            color: #666;
            font-weight: 600;
            border-radius: 10px;
            padding: 12px 20px;
            margin-bottom: 10px;
            transition: all 0.3s;
        }
        .nav-pills .nav-link:hover {
            background-color: var(--rani-light);
            color: var(--rani-pink);
        }
        .nav-pills .nav-link.active {
            background-color: var(--rani-pink) !important;
            color: white !important;
            box-shadow: 0 4px 10px rgba(255, 102, 163, 0.3);
        }

        #signaturePad {
            border: 2px dashed var(--rani-pink);
            border-radius: 12px;
            width: 100%;
            height: 160px;
            background: #fafafa;
            cursor: crosshair;
            touch-action: none;
        }

        @media (max-width: 768px) {
            .nav-pills {
                display: flex;
                flex-direction: row !important;
                overflow-x: auto;
                white-space: nowrap;
                padding-bottom: 10px;
            }
            .nav-pills .nav-link {
                margin-right: 10px;
                margin-bottom: 0;
            }
            .video-container {
                margin-top: 20px;
            }
        }

        table.dataTable thead th {
            background-color: var(--rani-light);
            color: #444;
            border-bottom: none;
        }
        .badge-masuk { background-color: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
        .badge-keluar { background-color: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
    </style>
</head>
<body>
    <audio id="audioSukses" src="https://www.soundjay.com/buttons/sounds/button-09.mp3" preload="auto"></audio>

    <nav class="navbar top-navbar mb-4 sticky-top">
        <div class="container-fluid px-lg-5 px-3">
            <a class="navbar-brand" href="#">🌸 Rani Skincare</a>
            <div class="d-flex align-items-center gap-3">
                <span class="text-white d-none d-md-inline"><i class="fa-solid fa-circle-user me-1"></i> Halo, Admin</span>
                <a href="logout.php" class="btn btn-sm btn-light text-danger fw-bold rounded-pill px-3 shadow-sm"><i class="fa-solid fa-arrow-right-from-bracket me-1"></i>Keluar</a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-lg-5 px-3 pb-5">
        <div class="row g-4 flex-column-reverse flex-lg-row">
            
            <div class="col-lg-3">
                <div class="card card-rani p-3 mb-4">
                    <h6 class="text-muted fw-bold mb-3 ps-2 text-uppercase" style="font-size: 12px;">Menu Utama</h6>
                    <ul class="nav nav-pills flex-column" id="menuTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active w-100 text-start" id="tab-master" data-bs-toggle="pill" data-bs-target="#content-master" type="button" role="tab">
                                <i class="fa-solid fa-boxes-stacked me-2"></i> Master Barang
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link w-100 text-start" id="tab-transaksi" data-bs-toggle="pill" data-bs-target="#content-transaksi" type="button" role="tab">
                                <i class="fa-solid fa-clock-rotate-left me-2"></i> Riwayat Transaksi
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card card-rani p-3 video-container">
                    <h6 class="text-muted fw-bold mb-3 ps-2 text-uppercase" style="font-size: 12px;"><i class="fa-solid fa-circle-play me-1"></i> Panduan Sistem</h6>
                    <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                        <iframe src="https://www.youtube.com/embed/Z6rgzKl3aEY" title="Panduan" allowfullscreen></iframe>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="tab-content" id="menuTabContent">
                    
                    <div class="tab-pane fade show active" id="content-master" role="tabpanel">
                        <div class="card card-rani">
                            <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h5 class="m-0 fw-bold text-dark"><i class="fa-solid fa-boxes-stacked text-rani me-2"></i>Data Master Stok</h5>
                                <button class="btn btn-rani shadow-sm" onclick="bukaModalMaster()"><i class="fa-solid fa-plus me-1"></i> Produk Baru</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tabelMaster" class="table table-hover align-middle w-100" style="font-size: 14px;">
                                        <thead>
                                            <tr>
                                                <th>Kode</th>
                                                <th>Nama Produk</th>
                                                <th>Kategori</th>
                                                <th>Sisa Stok</th>
                                                <th class="text-center">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($data_master as $m): ?>
                                            <tr data-kode="<?= $m['kode_barang']; ?>">
                                                <td><span class="badge bg-light text-dark border"><?= $m['kode_barang']; ?></span></td>
                                                <td class="fw-semibold text-dark"><?= $m['nama_produk']; ?></td>
                                                <td><?= $m['kategori']; ?></td>
                                                <td><h6 class="m-0"><span class="badge <?= $m['stok_sekarang'] > 10 ? 'bg-success' : 'bg-warning text-dark'; ?>"><?= $m['stok_sekarang']; ?> pcs</span></h6></td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-outline-primary" onclick="editMaster(this)" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
                                                        <button class="btn btn-sm btn-outline-danger" onclick="hapusMaster('<?= $m['kode_barang']; ?>')" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="content-transaksi" role="tabpanel">
                        <div class="card card-rani">
                            <div class="card-header-custom d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h5 class="m-0 fw-bold text-dark"><i class="fa-solid fa-clock-rotate-left text-rani me-2"></i>Log Transaksi Barang</h5>
                                <button class="btn btn-rani shadow-sm" onclick="bukaModalTransaksi()"><i class="fa-solid fa-bolt me-1"></i> Catat Transaksi</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tabelStok" class="table table-hover align-middle w-100" style="font-size: 14px;">
                                        <thead>
                                            <tr>
                                                <th>Tgl Input</th>
                                                <th>Kode & Produk</th>
                                                <th>Tipe</th>
                                                <th>Qty</th>
                                                <th class="text-center">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            error_reporting(0);
                                            if($koneksi) {
                                                $query = mysqli_query($koneksi, "SELECT * FROM stok_barang_rifan_2430511018 ORDER BY id DESC");
                                                if($query) {
                                                    while($data = mysqli_fetch_array($query)) {
                                                        $tgl = date('d/m/Y H:i', strtotime($data['tanggal_input']));
                                                        $stokTampil = $data['jumlah'];
                                                        $isMasuk = $data['tipe_transaksi'] == 'Masuk';
                                                        
                                                        $badgeClass = $isMasuk ? 'badge-masuk' : 'badge-keluar';
                                                        $iconClass = $isMasuk ? 'fa-arrow-down' : 'fa-arrow-up';
                                                        
                                                        if(!$isMasuk) $stokTampil = "-" . $data['jumlah'];
                                            ?>
                                            <tr data-id="<?= $data['id']; ?>">
                                                <td class="text-muted" style="font-size: 12px;"><?= $tgl; ?></td>
                                                <td>
                                                    <div class="fw-bold text-dark"><?= $data['nama_produk']; ?></div>
                                                    <div class="text-muted" style="font-size: 11px;"><?= $data['kode_barang']; ?></div>
                                                </td>
                                                <td><span class="badge <?= $badgeClass; ?> rounded-pill px-2"><i class="fa-solid <?= $iconClass; ?> me-1"></i><?= $data['tipe_transaksi']; ?></span></td>
                                                <td class="fw-bold <?= $isMasuk ? 'text-success' : 'text-danger'; ?>"><?= $stokTampil; ?></td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="cetak.php?id=<?= $data['id']; ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Cetak Nota"><i class="fa-solid fa-print"></i></a>
                                                        <button class="btn btn-sm btn-outline-primary" onclick="editTransaksi(this)" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
                                                        <button class="btn btn-sm btn-outline-danger" onclick="hapusTransaksi(this)" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php 
                                                    }
                                                }
                                            } 
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMaster" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none;">
                <div class="modal-header" style="background: var(--rani-pink); color: white; border-radius: 16px 16px 0 0;">
                    <h5 class="modal-title fw-bold" id="judulModalMaster">Form Master Barang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formMaster">
                        <input type="hidden" id="editKodeLama" name="editKodeLama" />
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted text-uppercase" style="font-size: 12px;">Kode SKU Barang <span class="text-danger">*</span></label>
                            <input type="text" id="kodeMaster" name="kode_barang" class="form-control form-control-lg bg-light" placeholder="Contoh: RSK-001" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-muted text-uppercase" style="font-size: 12px;">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" id="namaMaster" name="nama_produk" class="form-control form-control-lg bg-light" placeholder="Nama Skincare" required />
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label fw-semibold text-muted text-uppercase" style="font-size: 12px;">Kategori <span class="text-danger">*</span></label>
                                <select id="kategoriMaster" name="kategori" class="form-select form-select-lg bg-light" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Serum">Serum</option>
                                    <option value="Toner">Toner</option>
                                    <option value="Facial Wash">Facial Wash</option>
                                    <option value="Moisturizer">Moisturizer</option>
                                    <option value="Sunscreen">Sunscreen</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label fw-semibold text-muted text-uppercase" style="font-size: 12px;">Stok Awal (Pcs)</label>
                                <input type="number" id="stokMaster" name="stok_sekarang" class="form-control form-control-lg bg-light" value="0" min="0" required />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-rani px-4" onclick="simpanMaster()">Simpan Data</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTransaksi" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none;">
                <div class="modal-header" style="background: var(--rani-pink); color: white; border-radius: 16px 16px 0 0;">
                    <h5 class="modal-title fw-bold" id="judulModalTransaksi">Catat Log Transaksi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formTransaksi" enctype="multipart/form-data">
                        <input type="hidden" id="editIdTransaksi" name="id" />
                        <input type="hidden" id="namaProduk" name="namaProduk" />
                        <input type="hidden" id="kategoriProduk" name="kategoriProduk" />

                        <div class="row bg-light p-3 rounded mb-4">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted text-uppercase" style="font-size: 12px;">Arus Barang <span class="text-danger">*</span></label>
                                <select id="tipeTransaksi" name="tipeTransaksi" class="form-select border-primary" required>
                                    <option value="">-- Tentukan Arus --</option>
                                    <option value="Masuk">📥 Barang Masuk (Stok +)</option>
                                    <option value="Keluar">📤 Barang Keluar (Stok -)</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted text-uppercase" style="font-size: 12px;">Pilih Dari Master Barang <span class="text-danger">*</span></label>
                                <select id="kodeBarang" name="kodeBarang" class="form-select border-primary" onchange="sinkronisasiDataBarang()" required>
                                    <option value="">-- Pilih Produk --</option>
                                    <?php foreach($data_master as $m): ?>
                                        <option value="<?= $m['kode_barang']; ?>" data-nama="<?= $m['nama_produk']; ?>" data-kat="<?= $m['kategori']; ?>">
                                            <?= $m['kode_barang']; ?> - <?= $m['nama_produk']; ?> (Sisa: <?= $m['stok_sekarang']; ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold text-muted text-uppercase" style="font-size: 12px;">Jumlah (Qty) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" id="jumlahBarang" name="jumlahBarang" class="form-control" min="1" placeholder="0" required />
                                    <span class="input-group-text bg-white">Pcs</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-muted text-uppercase" style="font-size: 12px;">Lampiran / Faktur</label>
                                <input type="file" id="fileFaktur" name="fileFaktur[]" class="form-control" multiple accept="image/*,.pdf" />
                            </div>
                        </div>

                        <div class="text-center">
                            <label class="form-label fw-semibold text-muted text-uppercase" style="font-size: 12px;">Otorisasi Tanda Tangan</label>
                            <canvas id="signaturePad" class="shadow-sm"></canvas>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill mt-2 px-3" onclick="bersihkanTTD()"><i class="fa-solid fa-eraser me-1"></i>Hapus Coretan</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 pb-4 pe-4">
                    <button type="button" class="btn btn-light fw-bold px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-rani px-4" onclick="simpanTransaksi()"><i class="fa-solid fa-cloud-arrow-up me-1"></i> Proses Transaksi</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        let tabelMaster, tabelTransaksi;

        $(document).ready(function () {
            tabelMaster = $("#tabelMaster").DataTable({ responsive: true });
            tabelTransaksi = $("#tabelStok").DataTable({ responsive: true, order: [[ 0, "desc" ]] });

            // Cek tab mana yang aktif terakhir kali dari localStorage
            let activeTab = localStorage.getItem('activeTabRani');
            if (activeTab === 'transaksi') {
                let triggerEl = document.querySelector('#tab-transaksi');
                let tab = new bootstrap.Tab(triggerEl);
                tab.show();
            }

            // Simpan posisi tab ke localStorage setiap kali user klik menu navigasi
            $('button[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {
                let targetId = $(e.target).attr("id"); 
                if (targetId === 'tab-transaksi') {
                    localStorage.setItem('activeTabRani', 'transaksi');
                } else {
                    localStorage.setItem('activeTabRani', 'master');
                }
                // Menyesuaikan ulang lebar tabel biar presisi saat pindah tab
                $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
            });

            $("#modalTransaksi").on("shown.bs.modal", function () {
                initCanvas();
            });
        });

        // ==========================================
        // FITUR-FITUR INDUK MASTER BARANG
        // ==========================================
        function bukaModalMaster() {
            $("#formMaster")[0].reset();
            $("#editKodeLama").val(""); 
            $("#judulModalMaster").text("Daftarkan Produk Baru");
            $("#kodeMaster").prop("readonly", false);
            $("#modalMaster").modal("show"); 
        }

        function editMaster(button) {
            let tr = $(button).closest("tr");
            let data = tabelMaster.row(tr).data();
            let kodeAsli = $(tr).data('kode');

            $("#editKodeLama").val(kodeAsli);
            $("#kodeMaster").val(kodeAsli).prop("readonly", true);
            
            // Mengambil nama dan kategori (tanpa ikut menyedot tag HTML)
            let tempDiv1 = document.createElement("div"); tempDiv1.innerHTML = data[1];
            let tempDiv2 = document.createElement("div"); tempDiv2.innerHTML = data[2];
            $("#namaMaster").val(tempDiv1.innerText);
            $("#kategoriMaster").val(tempDiv2.innerText);
            
            // REVISI FIX 606: Membersihkan tag HTML dulu sebelum mengambil angkanya
            let tempDiv3 = document.createElement("div"); 
            tempDiv3.innerHTML = data[3];
            $("#stokMaster").val(tempDiv3.innerText.replace(/[^0-9]/g, ''));

            $("#judulModalMaster").text("Edit Master Barang");
            $("#modalMaster").modal("show");
        }

        function simpanMaster() {
            if(!$("#kodeMaster").val() || !$("#namaMaster").val()) { alert("Lengkapi Form!"); return; }
            let formData = new FormData(document.getElementById("formMaster"));
            
            $.ajax({
                url: 'proses_simpan_master.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if(response.includes("Sukses")) {
                        alert("Master Barang tersimpan!");
                        location.reload();
                    } else {
                        alert("Gagal: " + response);
                    }
                }
            });
        }

        function hapusMaster(kode) {
            if(confirm("Hapus barang SKU: " + kode + " dari Master Data?")) {
                $.ajax({
                    url: 'proses_hapus_master.php',
                    type: 'POST',
                    data: { kode: kode },
                    success: function(response) {
                        if (response.includes("Sukses")) {
                            location.reload();
                        } else {
                            alert("Gagal menghapus: " + response);
                        }
                    }
                });
            }
        }

        // ==========================================
        // FITUR-FITUR LOG TRANSAKSI BARANG
        // ==========================================
        function bukaModalTransaksi() {
            $("#formTransaksi")[0].reset();
            $("#editIdTransaksi").val(""); 
            $("#judulModalTransaksi").text("Catat Log Transaksi Baru");
            bersihkanTTD();
            $("#modalTransaksi").modal("show");
        }

        function sinkronisasiDataBarang() {
            let selectedOption = $("#kodeBarang option:selected");
            $("#namaProduk").val(selectedOption.data("nama"));
            $("#kategoriProduk").val(selectedOption.data("kat"));
        }

        function editTransaksi(button) {
            let tr = $(button).closest("tr");
            let idAsli = $(tr).data('id');
            let data = tabelTransaksi.row(tr).data();

            $("#editIdTransaksi").val(idAsli);
            $("#judulModalTransaksi").text("Edit Log Transaksi");
            
            let htmlDiv = document.createElement("div"); htmlDiv.innerHTML = data[1];
            let extractKode = htmlDiv.querySelector(".text-muted").innerText;
            $("#kodeBarang").val(extractKode); 
            sinkronisasiDataBarang(); 
            
            $("#tipeTransaksi").val(data[2].includes("Masuk") ? "Masuk" : "Keluar");
            $("#jumlahBarang").val(data[3].replace(/[^0-9]/g, ''));

            bersihkanTTD();
            $("#modalTransaksi").modal("show");
        }

        function simpanTransaksi() {
            if (!$("#tipeTransaksi").val() || !$("#kodeBarang").val() || !$("#jumlahBarang").val()) {
                alert("Gagal: Lengkapi Tipe Transaksi, Barang, dan Jumlah!");
                return;
            }

            let formElement = document.getElementById("formTransaksi");
            let formData = new FormData(formElement);

            let canvas = document.getElementById("signaturePad");
            let ttdData = canvas.toDataURL("image/png");
            formData.append("ttd_digital", ttdData); 

            $.ajax({
                url: 'proses_simpan.php',
                type: 'POST',
                data: formData,
                contentType: false, 
                processData: false, 
                success: function(response) {
                    if(response.includes("Sukses")) {
                        document.getElementById("audioSukses").play();
                        setTimeout(() => { location.reload(); }, 500); 
                    } else {
                        alert("Gagal menyimpan: " + response);
                    }
                }
            });
        }

        function hapusTransaksi(button) {
            let id = $(button).closest("tr").data("id");
            if (confirm("Hapus log transaksi ini? Stok otomatis di-rollback.")) {
                $.ajax({
                    url: 'proses_hapus.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        if (response.includes("Sukses")) { location.reload(); } 
                        else { alert("Gagal: " + response); }
                    }
                });
            }
        }

        // ==========================================
        // KODE CANVAS DIGITAL SIGNATURE
        // ==========================================
        let canvas, ctx, isDrawing = false;
        
        function initCanvas() {
            canvas = document.getElementById("signaturePad");
            if (!canvas) return; 
            
            ctx = canvas.getContext("2d");
            let rect = canvas.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = rect.height;

            $(canvas).off("mousedown mousemove mouseup mouseout touchstart touchmove touchend");

            $(canvas).on("mousedown", startDraw);
            $(canvas).on("mousemove", draw);
            $(canvas).on("mouseup mouseout", stopDraw);

            $(canvas).on("touchstart", function (e) { startDraw(e.originalEvent); });
            $(canvas).on("touchmove", function (e) { draw(e.originalEvent); });
            $(canvas).on("touchend", stopDraw);
        }

        function getPos(e) {
            let rect = canvas.getBoundingClientRect();
            let clientX = e.clientX;
            let clientY = e.clientY;
            
            if (e.touches && e.touches.length > 0) {
                clientX = e.touches[0].clientX;
                clientY = e.touches[0].clientY;
            }
            return { x: clientX - rect.left, y: clientY - rect.top };
        }

        function startDraw(e) { 
            e.preventDefault(); 
            isDrawing = true; 
            let pos = getPos(e); 
            ctx.beginPath(); 
            ctx.moveTo(pos.x, pos.y); 
        }

        function draw(e) {
            if (!isDrawing) return;
            e.preventDefault();
            let pos = getPos(e);
            ctx.lineTo(pos.x, pos.y);
            ctx.strokeStyle = "#ff66a3"; 
            ctx.lineWidth = 3;
            ctx.lineCap = "round";
            ctx.stroke();
        }

        function stopDraw() { isDrawing = false; if (ctx) ctx.closePath(); }
        function bersihkanTTD() { if (ctx && canvas) ctx.clearRect(0, 0, canvas.width, canvas.height); }
    </script>
</body>
</html>