<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventaris - Toko Rani Skincare</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"
    />

    <style>
      :root {
        --rani-pink: #ff66a3;
        --rani-light: #ffe6f0;
      }
      body {
        background-color: #f9f9f9;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        overflow-x: hidden;
      }

      .fade-in {
        animation: fadeIn 0.5s ease-in-out;
      }
      @keyframes fadeIn {
        from {
          opacity: 0;
          transform: translateY(-10px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      .bg-rani {
        background-color: var(--rani-pink) !important;
        color: white;
      }
      .text-rani {
        color: var(--rani-pink) !important;
      }
      .btn-rani {
        background-color: var(--rani-pink);
        color: white;
        border: none;
      }
      .btn-rani:hover {
        background-color: #e65590;
        color: white;
      }
      .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
      }

      /* Canvas TTD */
      #signaturePad {
        border: 2px dashed var(--rani-pink);
        border-radius: 8px;
        width: 100%;
        height: 150px;
        background: #fff;
        cursor: crosshair;
        touch-action: none;
      }
      #dashboard {
        display: none;
      }

      /* Responsif untuk tabel di HP */
      @media (max-width: 768px) {
        .video-container {
          display: none;
        } 
      }
    </style>
  </head>
  <body>
    <audio
      id="audioSukses"
      src="https://www.soundjay.com/buttons/sounds/button-09.mp3"
      preload="auto"
    ></audio>

    <div class="container mt-5 fade-in" id="loginPage">
      <div class="row justify-content-center">
        <div class="col-md-5 col-sm-10">
          <div class="card p-4 text-center">
            <h3 class="text-rani">🌸 Rani Skincare</h3>
            <p class="text-muted">Sistem Inventaris Barang</p>
            <form
              onsubmit="
                event.preventDefault();
                login();
              "
            >
              <input
                type="text"
                id="username"
                class="form-control mb-3"
                placeholder="Username"
                required
              />
              <input
                type="password"
                id="password"
                class="form-control mb-3"
                placeholder="Password"
                required
              />
              <button type="submit" class="btn btn-rani w-100">
                Login Sistem
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid mt-4 fade-in px-4" id="dashboard">
      <div
        class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2"
      >
        <h3 class="text-rani m-0">🌸 Inventaris Rani Skincare</h3>
        <button class="btn btn-danger btn-sm" onclick="logout()">Logout</button>
      </div>

      <div class="row mb-4">
        <div class="col-lg-3 col-md-4 mb-3 video-container">
          <div class="card p-3">
            <h6 class="text-center">Panduan Sistem</h6>
            <iframe 
              width="100%" 
              height="200" 
              src="https://www.youtube.com/embed/Z6rgzKl3aEY" 
              title="Panduan Sistem Rani Skincare" 
              frameborder="0" 
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
              allowfullscreen 
              style="border-radius: 8px;">
            </iframe>
          </div>
        </div>

        <div class="col-lg-9 col-md-8">
          <div class="card p-3">
            <div class="mb-3">
              <button class="btn btn-rani" onclick="bukaModalTambah()">
                + Transaksi Barang
              </button>
            </div>
            <div class="table-responsive">
              <table id="tabelStok" class="table table-hover w-100">
                <thead class="bg-rani">
                  <tr>
                    <th>Kode</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Sembunyikan pesan error mysqli (jika belum bikin database) saat pertama dimuat
                  error_reporting(0);
                  include 'koneksi.php';
                  
                  if($koneksi) {
                      $query = mysqli_query($koneksi, "SELECT * FROM stok_barang ORDER BY id DESC");
                      if($query) {
                          while($data = mysqli_fetch_array($query)) {
                              $stokTampil = $data['jumlah'];
                              if($data['tipe_transaksi'] == 'Keluar') {
                                  $stokTampil = "-" . $data['jumlah'];
                              }
                  ?>
                  <tr data-id="<?= $data['id']; ?>">
                    <td><?= $data['kode_barang']; ?></td>
                    <td><?= $data['nama_produk']; ?></td>
                    <td><?= $data['kategori']; ?></td>
                    <td><?= $stokTampil; ?></td>
                    <td>
                      <button class="btn btn-sm btn-warning mb-1" onclick="editData(this)">Edit</button>
                      <button class="btn btn-sm btn-danger mb-1" onclick="hapusData(this)">Hapus</button>
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

    <div class="modal fade" id="modalTransaksi" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-rani text-white">
            <h5 class="modal-title" id="judulModal">Form Transaksi Barang</h5>
            <button
              type="button"
              class="btn-close btn-close-white"
              data-bs-dismiss="modal"
            ></button>
          </div>
          <div class="modal-body">
            <form id="formBarang" enctype="multipart/form-data">
              <input type="hidden" id="editRowIndex" />

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label>Tipe Transaksi <span class="text-danger">*</span></label>
                  <select id="tipeTransaksi" name="tipeTransaksi" class="form-select" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="Masuk">Barang Masuk (+)</option>
                    <option value="Keluar">Barang Keluar (-)</option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label>Kode Barang <span class="text-danger">*</span></label>
                  <input
                    type="text"
                    id="kodeBarang"
                    name="kodeBarang"
                    class="form-control"
                    placeholder="Contoh: RSK-002"
                    required
                  />
                </div>
                <div class="col-md-6 mb-3">
                  <label>Nama Produk <span class="text-danger">*</span></label>
                  <input
                    type="text"
                    id="namaProduk"
                    name="namaProduk"
                    class="form-control"
                    required
                  />
                </div>
                <div class="col-md-6 mb-3">
                  <label>Kategori <span class="text-danger">*</span></label>
                  <select id="kategoriProduk" name="kategoriProduk" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Serum">Serum</option>
                    <option value="Toner">Toner</option>
                    <option value="Facial Wash">Facial Wash</option>
                    <option value="Sunscreen">Sunscreen</option>
                    <option value="Lainnya">Lainnya</option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label>Jumlah <span class="text-danger">*</span></label>
                  <input
                    type="number"
                    id="jumlahBarang"
                    name="jumlahBarang"
                    class="form-control"
                    min="1"
                    required
                  />
                </div>
                <div class="col-md-6 mb-3">
                  <label>Upload Faktur (Opsional)</label>
                  <input
                    type="file"
                    id="fileFaktur"
                    name="fileFaktur[]"
                    class="form-control"
                    multiple
                    accept="image/*,.pdf"
                  />
                </div>
              </div>

              <div class="mb-3 text-center">
                <label>Tanda Tangan Penanggung Jawab</label>
                <canvas id="signaturePad"></canvas>
                <br />
                <button
                  type="button"
                  class="btn btn-sm btn-outline-secondary mt-2"
                  onclick="bersihkanTTD()"
                >
                  Hapus Coretan
                </button>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
              Batal
            </button>
            <button type="button" class="btn btn-rani" onclick="simpanData()">
              Simpan Data
            </button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
      let dataTable;

      $(document).ready(function () {
        dataTable = $("#tabelStok").DataTable({
          responsive: true,
          language: { search: "Cari Produk:" },
        });

        $("#modalTransaksi").on("shown.bs.modal", function () {
          initCanvas();
        });
      });

      // ================= FITUR LOGIN & LOGOUT =================
      function login() {
        if ($("#username").val() === "" || $("#password").val() === "") {
          alert("Harap isi username dan password!");
          return;
        }
        $("#loginPage").hide();
        $("#dashboard").show();
      }

      function logout() {
        $("#dashboard").hide();
        $("#loginPage").show();
        $("#username").val("");
        $("#password").val("");
      }

      // ================= FITUR CRUD & VALIDASI =================
      function bukaModalTambah() {
        $("#formBarang")[0].reset();
        $("#editRowIndex").val(""); 
        $("#judulModal").text("Form Transaksi Barang Baru");
        bersihkanTTD();
        $("#modalTransaksi").modal("show");
      }

      function simpanData() {
        let tipe = $("#tipeTransaksi").val();
        let kode = $("#kodeBarang").val();
        let nama = $("#namaProduk").val();
        let kategori = $("#kategoriProduk").val();
        let jumlah = parseInt($("#jumlahBarang").val());
        let isEdit = $("#editRowIndex").val(); 

        if (!tipe || !kode || !nama || !kategori || !jumlah) {
          alert("Validasi Gagal: Semua field dengan tanda (*) wajib diisi!");
          return;
        }
        if (jumlah < 1) {
          alert("Validasi Gagal: Jumlah barang minimal 1!");
          return;
        }

        let formElement = document.getElementById("formBarang");
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
                    alert("Transaksi Berhasil Disimpan ke Database!");
                    
                    // Reload halaman agar tabel memuat ID baru dari database secara akurat
                    location.reload();
                } else {
                    alert("Gagal menyimpan ke database. Pesan error: " + response);
                }
            },
            error: function() {
                alert("Gagal menghubungi server! Pastikan Laragon/XAMPP menyala.");
            }
        });
      }

      function editData(button) {
        let tr = $(button).closest("tr");
        let row = dataTable.row(tr);
        let data = row.data();

        $("#kodeBarang").val(data[0]);
        $("#namaProduk").val(data[1]);
        $("#kategoriProduk").val(data[2]);
        $("#jumlahBarang").val(Math.abs(parseInt(data[3])));
        $("#tipeTransaksi").val(parseInt(data[3]) < 0 ? "Keluar" : "Masuk");

        $("#editRowIndex").val(row.index());
        $("#judulModal").text("Edit Data Transaksi (Tampilan Sementara)");
        bersihkanTTD();

        $("#modalTransaksi").modal("show");
      }

      // Logika Hapus Sinkron dengan Database
      function hapusData(button) {
        let tr = $(button).closest("tr");
        let id = tr.data("id"); // Ambil ID baris dari database

        if (!id) {
            // Pengaman jika menghapus baris kosong lokal
            dataTable.row(tr).remove().draw();
            return;
        }

        if (confirm("Yakin ingin menghapus data transaksi ini dari Database beneran?")) {
            $.ajax({
                url: 'proses_hapus.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    if (response.includes("Sukses")) {
                        dataTable.row(tr).remove().draw();
                        alert("Data Berhasil Dihapus Permanen dari Database!");
                    } else {
                        alert("Gagal menghapus di database: " + response);
                    }
                },
                error: function() {
                    alert("Koneksi ke server bermasalah!");
                }
            });
        }
      }

      // ================= FITUR CANVAS (TTD DIGITAL) =================
      let canvas, ctx, isDrawing = false;

      function initCanvas() {
        canvas = document.getElementById("signaturePad");
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
        let x = e.clientX || (e.touches && e.touches[0].clientX);
        let y = e.clientY || (e.touches && e.touches[0].clientY);
        return { x: x - rect.left, y: y - rect.top };
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
        ctx.strokeStyle = "#333";
        ctx.lineWidth = 2;
        ctx.stroke();
      }

      function stopDraw() {
        isDrawing = false;
        if (ctx) ctx.closePath();
      }

      function bersihkanTTD() {
        if (ctx && canvas) ctx.clearRect(0, 0, canvas.width, canvas.height);
      }
    </script>
  </body>
</html>