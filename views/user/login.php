<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập - HihiMart</title>
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
      <p class="brand-subtitle">Mua sắm thảnh thơi, Giá luôn tuyệt vời!</p>
    </div>

    <!-- Login Form -->
    <div class="login-card-modern">
      <div class="card-header">
        <div class="login-icon">
          <i class="bi bi-person-circle"></i>
        </div>
        <h3 class="login-title">Đăng nhập</h3>
        <p class="login-subtitle">Chào mừng bạn trở lại!</p>
      </div>

      <?php if (!empty($error)): ?>
        <div class="alert-modern alert-error">
          <i class="bi bi-exclamation-triangle-fill"></i>
          <span><?php echo $error; ?></span>
        </div>
      <?php endif; ?>

      <form method="post" action="" autocomplete="off" class="login-form">
        <div class="form-group-modern">
          <div class="input-wrapper">
            <i class="bi bi-envelope-at input-icon"></i>
            <input type="email" name="email" class="form-input-modern" placeholder="Nhập email của bạn" required autofocus>
            <label class="form-label-modern">Email</label>
          </div>
        </div>

        <div class="form-group-modern">
          <div class="input-wrapper">
            <i class="bi bi-lock input-icon"></i>
            <input type="password" name="password" class="form-input-modern" placeholder="Nhập mật khẩu" required id="userPassword">
            <label class="form-label-modern">Mật khẩu</label>
            <button type="button" class="password-toggle" onclick="togglePasswordModern()">
              <i class="bi bi-eye-slash" id="toggleIcon"></i>
            </button>
          </div>
        </div>

        <div class="form-options">
          <label class="checkbox-modern">
            <input type="checkbox" name="remember">
            <span class="checkmark"></span>
            Ghi nhớ đăng nhập
          </label>
          <a href="reset_password.php" class="forgot-link">Quên mật khẩu?</a>
        </div>

        <button type="submit" name="login" class="login-btn">
          <span class="btn-text">Đăng nhập</span>
          <i class="bi bi-arrow-right btn-icon"></i>
        </button>

        <div class="divider">
          <span>hoặc</span>
        </div>

        <div class="social-login">
          <button type="button" class="btn-social btn-google">
            <i class="bi bi-google"></i>
            Google
          </button>
          <button type="button" class="btn-social btn-facebook">
            <i class="bi bi-facebook"></i>
            Facebook
          </button>
        </div>

        <div class="signup-link">
          Chưa có tài khoản? 
          <a href="index.php?controller=user&action=register">Đăng ký ngay</a>
        </div>
      </form>
    </div>
  </div>
</div>
<link rel="stylesheet" href="/do_dien_tu/public/assets/css/auth.css">
<script src="/do_dien_tu/public/assets/js/auth.js"></script>
<script>
  // Modern password toggle function
  function togglePasswordModern() {
    const pwd = document.getElementById('userPassword');
    const icon = document.getElementById('toggleIcon');
    
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
  
  // Enhanced form validation
  function validateLogin() {
    const email = document.querySelector('input[name="email"]');
    const password = document.querySelector('input[name="password"]');
    let isValid = true;
    
    // Reset previous validation states
    email.style.borderColor = '#e2e8f0';
    password.style.borderColor = '#e2e8f0';
    
    // Email validation
    if (!email.value.trim()) {
      email.style.borderColor = '#dc2626';
      email.focus();
      isValid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
      email.style.borderColor = '#dc2626';
      email.focus();
      isValid = false;
    }
    
    // Password validation
    if (!password.value.trim()) {
      password.style.borderColor = '#dc2626';
      if (isValid) password.focus();
      isValid = false;
    }
    
    return isValid;
  }
  
  // Add loading state to login button
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.login-form');
    const loginBtn = document.querySelector('.btn-login-modern');
    
    if (form && loginBtn) {
      form.addEventListener('submit', function(e) {
        if (validateLogin()) {
          loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Đang đăng nhập...';
          loginBtn.disabled = true;
        }
      });
    }
    
    // Add floating label effect
    const inputs = document.querySelectorAll('.form-input-modern');
    inputs.forEach(input => {
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
</body>
</html>
