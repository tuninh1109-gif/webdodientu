<?php
session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = md5($_POST['password']); // Mật khẩu mã hoá md5

    $sql = "SELECT * FROM taikhoan_admin WHERE username='$user' AND password='$pass'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $_SESSION['admin'] = $user;
        header("Location: index.php");
        exit;
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập Quản trị - HihiMart</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #2196f3 60%, #0d6efd 100%);
      display: flex; align-items: center; justify-content: center;
    }
    .login-card {
      border-radius: 18px;
      box-shadow: 0 6px 36px rgba(33,150,243,0.12);
      background: #fff;
      padding: 36px 30px 28px 30px;
      max-width: 400px;
      margin: auto;
      position: relative;
    }
    .login-logo {
      width: 56px; height: 56px;
      background: #fff3cd;
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      margin: 0 auto 18px auto;
      font-size: 2.2rem; color: #ff9800; box-shadow: 0 2px 8px #ffe082;
    }
    .form-control:focus {
      border-color: #2196f3; box-shadow: 0 0 0 2px #2196f333;
    }
    .input-group-text { background: #f6f8fa; }
    .show-hide {
      cursor:pointer; color:#888; font-size:1.1em;
    }
    @media (max-width: 500px) {
      .login-card { padding: 18px 6px; }
    }
  </style>
</head>
<body>
  <div class="login-card">
    <div class="login-logo mb-2"><i class="bi bi-lightning-charge-fill"></i></div>
    <h4 class="text-center fw-bold mb-3" style="color:#223366;">Đăng nhập quản trị</h4>
    <?php if (isset($error)) echo "<div class='alert alert-danger d-flex align-items-center gap-2'><i class='bi bi-exclamation-triangle-fill me-2'></i> $error</div>"; ?>
    <form method="POST" autocomplete="off">
      <div class="mb-3">
        <label class="form-label">Tên đăng nhập</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
          <input type="text" name="username" class="form-control" required autofocus>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Mật khẩu</label>
        <div class="input-group" id="show_hide_password">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input type="password" name="password" class="form-control" required id="adminPassword">
          <span class="input-group-text show-hide" onclick="togglePassword()"><i class="bi bi-eye-slash" id="toggleIcon"></i></span>
        </div>
      </div>
      <button type="submit" class="btn btn-warning w-100 fw-bold py-2 mt-2"><i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập</button>
    </form>
    <div class="text-center text-muted mt-3" style="font-size:0.95em;">© HihiMart Quản trị 2025</div>
  </div>
  <script>
    function togglePassword() {
      const pwd = document.getElementById('adminPassword');
      const icon = document.getElementById('toggleIcon');
      if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      } else {
        pwd.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      }
    }
  </script>
</body>
</html>
