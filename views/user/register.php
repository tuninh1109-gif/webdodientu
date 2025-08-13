<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký - HihiMart</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/do_dien_tu/public/assets/css/auth.css">
</head>
<body>

<!-- Animated Background -->
<div class="auth-background">
  <div class="floating-shapes">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
    <div class="shape shape-4"></div>
    <div class="shape shape-5"></div>
  </div>
</div>

<div class="auth-container">
  <div class="auth-wrapper">
    <!-- Brand Section -->
    <div class="brand-section">
      <div class="brand-logo">
        <i class="bi bi-lightning-charge-fill"></i>
      </div>
      <h2 class="brand-title">HihiMart</h2>
      <p class="brand-subtitle">Tham gia cộng đồng mua sắm thông minh!</p>
    </div>

    <!-- Register Form -->
    <div class="login-card-modern">
      <div class="card-header">
        <div class="login-icon" style="background: linear-gradient(135deg, #48bb78, #38a169);">
          <i class="bi bi-person-plus"></i>
        </div>
        <h3 class="login-title">Đăng ký</h3>
        <p class="login-subtitle">Tạo tài khoản mới ngay hôm nay!</p>
      </div>
      
      <!-- Alert Messages -->
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger modern-alert">
          <i class="bi bi-exclamation-triangle-fill"></i>
          <span><?php echo $error; ?></span>
        </div>
      <?php endif; ?>
      
      <?php if (!empty($success)): ?>
        <div class="alert alert-success modern-alert">
          <i class="bi bi-check-circle-fill"></i>
          <span><?php echo $success; ?></span>
        </div>
      <?php endif; ?>

      <form method="post" action="" class="login-form" id="registerForm">
        <!-- Full Name -->
        <div class="form-group-modern">
          <div class="input-wrapper">
            <i class="bi bi-person input-icon"></i>
            <input type="text" name="tenkh" class="form-input-modern" placeholder=" " value="<?php echo htmlspecialchars($_POST['tenkh'] ?? ''); ?>" required>
            <label class="form-label-modern">Họ và tên</label>
          </div>
        </div>

        <!-- Email -->
        <div class="form-group-modern">
          <div class="input-wrapper">
            <i class="bi bi-envelope-at input-icon"></i>
            <input type="email" name="email" class="form-input-modern" placeholder=" " value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
            <label class="form-label-modern">Email</label>
          </div>
        </div>

        <!-- Phone -->
        <div class="form-group-modern">
          <div class="input-wrapper">
            <i class="bi bi-telephone input-icon"></i>
            <input type="tel" name="sodienthoai" class="form-input-modern" placeholder=" " value="<?php echo htmlspecialchars($_POST['sodienthoai'] ?? ''); ?>" required>
            <label class="form-label-modern">Số điện thoại</label>
          </div>
        </div>

        <!-- Address -->
        <div class="form-group-modern">
          <div class="input-wrapper">
            <i class="bi bi-geo-alt input-icon"></i>
            <input type="text" name="diachi" class="form-input-modern" placeholder=" " value="<?php echo htmlspecialchars($_POST['diachi'] ?? ''); ?>" required>
            <label class="form-label-modern">Địa chỉ</label>
          </div>
        </div>

        <!-- Password -->
        <div class="form-group-modern">
          <div class="input-wrapper">
            <i class="bi bi-lock input-icon"></i>
            <input type="password" name="password" class="form-input-modern" placeholder=" " required id="regPassword">
            <label class="form-label-modern">Mật khẩu</label>
            <button type="button" class="password-toggle" onclick="togglePasswordModern()">
              <i class="bi bi-eye-slash" id="toggleIcon1"></i>
            </button>
          </div>
        </div>

        <!-- Confirm Password -->
        <div class="form-group-modern">
          <div class="input-wrapper">
            <i class="bi bi-lock-fill input-icon"></i>
            <input type="password" name="repassword" class="form-input-modern" placeholder=" " required id="regRePassword">
            <label class="form-label-modern">Xác nhận mật khẩu</label>
            <button type="button" class="password-toggle" onclick="togglePasswordModern2()">
              <i class="bi bi-eye-slash" id="toggleIcon2"></i>
            </button>
          </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" name="register" class="login-btn" id="registerBtn">
          <span class="btn-text">Đăng ký</span>
          <div class="btn-spinner" style="display: none;">
            <div class="spinner-border spinner-border-sm" role="status"></div>
          </div>
        </button>
      </form>

      <!-- Login Link -->
      <div class="auth-links">
        <p>Bạn đã có tài khoản? <a href="/do_dien_tu/index.php?controller=user&action=login">Đăng nhập ngay</a></p>
      </div>
  
</script>
</div>
</div>

    </div>
  </div>
</div>

<!-- Footer -->
<div class="auth-footer">
  <div class="container text-center">
    <p class="mb-2">&copy; 2024 HihiMart. All rights reserved.</p>
    <div class="footer-links">
      <a href="/do_dien_tu/index.php">Trang chủ</a>
      <span>|</span>
      <a href="#">Liên hệ</a>
      <span>|</span>
      <a href="#">Chính sách</a>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Modern password toggle functions
  function togglePasswordModern() {
    const pwd = document.getElementById('regPassword');
    const icon = document.getElementById('toggleIcon1');
    
    if (pwd && icon) {
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
  }
  
  function togglePasswordModern2() {
    const pwd = document.getElementById('regRePassword');
    const icon = document.getElementById('toggleIcon2');
    
    if (pwd && icon) {
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
  }
  
  // Floating label animations (same as login page)
  document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.form-input-modern');
    
    inputs.forEach(function(input) {
      // Check if input has value on page load
      if (input.value) {
        const label = input.nextElementSibling;
        if (label && label.classList.contains('form-label-modern')) {
          label.style.transform = 'translateY(-28px) scale(0.85)';
          label.style.color = '#4a5568';
        }
      }
      
      // Add focus/blur events
      input.addEventListener('focus', function() {
        const label = this.nextElementSibling;
        if (label && label.classList.contains('form-label-modern')) {
          label.style.transform = 'translateY(-28px) scale(0.85)';
          label.style.color = '#667eea';
        }
      });
      
      input.addEventListener('blur', function() {
        const label = this.nextElementSibling;
        if (label && label.classList.contains('form-label-modern') && !this.value) {
          label.style.transform = 'translateY(0) scale(1)';
          label.style.color = '#a0aec0';
        }
      });
    });
  });
</script>
</body>
</html>
