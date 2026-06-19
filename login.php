<?php
session_start();
include 'koneksi.php';

// Jika sudah login, langsung alihkan ke dashboard index.php
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

$error = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi sederhana (bisa kamu ganti atau hubungkan ke tabel user jika diperlukan)
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['login'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = true;
    }
}
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Rani Skincare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
      :root { --rani-pink: #ff66a3; }
      body { background-color: #f9f9f9; font-family: 'Segoe UI', sans-serif; }
      .btn-rani { background-color: var(--rani-pink); color: white; border: none; }
      .btn-rani:hover { background-color: #e65590; color: white; }
      .card { border-radius: 12px; border: none; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); }
      .text-rani { color: var(--rani-pink) !important; }
    </style>
  </head>
  <body>
    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-4 col-sm-10 mt-5">
          <div class="card p-4 text-center">
            <h3 class="text-rani">🌸 Rani Skincare</h3>
            <p class="text-muted">Sistem Inventaris Barang</p>
            
            <?php if ($error): ?>
              <div class="alert alert-danger py-2" role="alert" style="font-size: 14px;">
                Username atau password salah!
              </div>
            <?php endif; ?>

            <form action="" method="POST">
              <input type="text" name="username" class="form-control mb-3" placeholder="Username" required />
              <input type="password" name="password" class="form-control mb-3" placeholder="Password" required />
              <button type="submit" class="btn btn-rani w-100">Login Sistem</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>