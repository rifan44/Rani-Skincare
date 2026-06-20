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
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <style>
      :root { 
        --rani-pink: #ff66a3; 
        --rani-dark: #e65590;
        --bg-color: #f4f7f6;
      }
      body { 
        background-color: var(--bg-color); 
        font-family: 'Poppins', sans-serif; 
      }
      .card-login { 
        border-radius: 16px; 
        border: none; 
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05); 
        background: #ffffff; /* FIX: Error #wrap diubah menjadi #ffffff (putih) */
      }
      .btn-rani { 
        background-color: var(--rani-pink); 
        color: white; 
        border: none; 
        font-weight: 500;
        transition: all 0.3s;
      }
      .btn-rani:hover { 
        background-color: var(--rani-dark); 
        color: white; 
        transform: translateY(-1px);
      }
      .text-rani { color: var(--rani-pink) !important; }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-4 col-sm-8 px-3">
          <div class="card card-login p-4 text-center">
            <h3 class="text-rani fw-bold m-0">🌸 Rani Skincare</h3>
            <p class="text-muted small mt-1 mb-4">Sistem Inventaris Barang</p>
            
            <?php if ($error): ?>
              <div class="alert alert-danger py-2" role="alert" style="font-size: 14px; border-radius: 8px;">
                <i class="fa-solid fa-circle-exclamation me-1"></i> Username atau password salah!
              </div>
            <?php endif; ?>

            <form action="" method="POST">
              <div class="mb-3 text-start">
                <input type="text" name="username" class="form-control form-control-lg bg-light border-0" placeholder="Username" style="font-size: 15px; border-radius: 10px;" required />
              </div>
              <div class="mb-4 text-start">
                <input type="password" name="password" class="form-control form-control-lg bg-light border-0" placeholder="Password" style="font-size: 15px; border-radius: 10px;" required />
              </div>
              <button type="submit" class="btn btn-rani w-100 py-2 rounded-pill shadow-sm"><i class="fa-solid fa-right-to-bracket me-2"></i>Login Sistem</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>