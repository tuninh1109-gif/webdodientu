<?php
// Trang lấy lại mật khẩu đơn giản: nhập email, gửi hướng dẫn (demo: chỉ hiển thị thông báo)
// Có thể mở rộng gửi mail thực tế nếu cần
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quên mật khẩu - HihiMart</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/do_dien_tu/public/assets/css/auth.css">
<script src="/do_dien_tu/public/assets/js/auth.js"></script>
</head>
<body>
<div class="reset-card mt-5">
  <div class="reset-logo mb-2"><i class="bi bi-key-fill"></i></div>
  <h4 class="text-center fw-bold mb-3" style="color:#223366;">Quên mật khẩu?</h4>
  <?php
    $msg = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = trim($_POST['email'] ?? '');
      if ($email === '') {
        $msg = "<div class='alert alert-danger d-flex align-items-center gap-2'><i class='bi bi-exclamation-triangle-fill me-2'></i>Vui lòng nhập email!</div>";
      } else {
        // TODO: Gửi mail thực tế nếu muốn
        $msg = "<div class='alert alert-success d-flex align-items-center gap-2'><i class='bi bi-envelope-check-fill me-2'></i>Nếu email hợp lệ, hướng dẫn đặt lại mật khẩu đã được gửi tới email của bạn!</div>";
      }
    }
    if ($msg) echo $msg;
  ?>
  <form method="post" action="" autocomplete="off" onsubmit="return validateResetPassword()">
    <div class="mb-3">
      <label class="form-label">Nhập email đã đăng ký</label>
      <div class="input-group">
        <span class="input-group-text"><i class="bi bi-envelope-at"></i></span>
        <input type="email" name="email" class="form-control" required autofocus>
      </div>
    </div>
    <button class="btn btn-warning w-100 fw-bold py-2 mt-2" type="submit"><i class="bi bi-envelope-arrow-up me-1"></i>Gửi hướng dẫn</button>
    <div class="mt-3 text-center">
      <a href="index.php?controller=user&action=login" class="fw-semibold"><i class="bi bi-arrow-left"></i> Quay lại đăng nhập</a>
    </div>
  </form>
</div>
</body>
</html>
