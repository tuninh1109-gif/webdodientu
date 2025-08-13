// auth.js - script cho giao diện đăng nhập/đăng ký/quen mật khẩu
function togglePassword(inputId, iconId) {
  const pwd = document.getElementById(inputId);
  const icon = document.getElementById(iconId);
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
function togglePasswordSimple(pwdId, iconId) {
  const pwd = document.getElementById(pwdId);
  const icon = document.getElementById(iconId);
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
function validateRegister() {
  let ok = true;
  let msg = '';
  // Họ tên
  const name = document.querySelector('input[name="tenkh"]');
  if (name.value.trim().length < 2) {
    name.classList.add('is-invalid');
    msg += 'Họ tên phải từ 2 ký tự.\n'; ok = false;
  } else name.classList.remove('is-invalid');
  // Email
  const email = document.querySelector('input[name="email"]');
  const reEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
  if (!reEmail.test(email.value.trim())) {
    email.classList.add('is-invalid');
    msg += 'Email không hợp lệ.\n'; ok = false;
  } else email.classList.remove('is-invalid');
  // Mật khẩu
  const pwd = document.getElementById('regPassword');
  if (pwd.value.length < 6) {
    pwd.classList.add('is-invalid');
    msg += 'Mật khẩu tối thiểu 6 ký tự.\n'; ok = false;
  } else pwd.classList.remove('is-invalid');
  // Nhập lại mật khẩu
  const repwd = document.getElementById('regRePassword');
  if (pwd.value !== repwd.value) {
    repwd.classList.add('is-invalid');
    msg += 'Mật khẩu nhập lại không khớp.\n'; ok = false;
  } else repwd.classList.remove('is-invalid');
  // Số điện thoại
  const phone = document.querySelector('input[name="sodienthoai"]');
  if (!/^\d{8,15}$/.test(phone.value.trim())) {
    phone.classList.add('is-invalid');
    msg += 'Số điện thoại không hợp lệ.\n'; ok = false;
  } else phone.classList.remove('is-invalid');
  // Địa chỉ
  const addr = document.querySelector('input[name="diachi"]');
  if (addr.value.trim().length < 3) {
    addr.classList.add('is-invalid');
    msg += 'Địa chỉ phải từ 3 ký tự.\n'; ok = false;
  } else addr.classList.remove('is-invalid');
  // Hiện alert lỗi
  if (!ok) {
    alert(msg);
    return false;
  }
  return true;
}
// Độ mạnh mật khẩu
if (document.getElementById('regPassword')) {
  document.getElementById('regPassword').addEventListener('input', function() {
    let val = this.value;
    let strength = 0;
    if (val.length >= 6) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/[0-9]/.test(val)) strength++;
    if (/[^A-Za-z0-9]/.test(val)) strength++;
    let msg = '';
    if (val.length > 0) {
      if (strength <= 1) msg = 'Yếu';
      else if (strength == 2) msg = 'Trung bình';
      else if (strength >= 3) msg = 'Mạnh';
    }
    let el = document.getElementById('pwdStrength');
    if (!el) {
      el = document.createElement('div');
      el.id = 'pwdStrength';
      el.style.fontSize = '0.95em';
      el.style.marginTop = '0.2em';
      el.style.color = '#1976d2';
      this.parentNode.appendChild(el);
    }
    el.innerText = msg;
  });
}
// Đơn giản cho login, reset_password: togglePasswordSimple('userPassword', 'toggleIcon')
// hoặc togglePasswordSimple('adminPassword', 'toggleIcon')

function validateResetPassword() {
  const email = document.querySelector('input[name="email"]');
  const reEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
  if (!reEmail.test(email.value.trim())) {
    email.classList.add('is-invalid');
    alert('Email không hợp lệ!');
    return false;
  } else {
    email.classList.remove('is-invalid');
  }
  return true;
}

function validateLogin() {
  let ok = true;
  let msg = '';
  const email = document.querySelector('input[name="email"]');
  const pwd = document.getElementById('userPassword');
  const reEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
  if (!reEmail.test(email.value.trim())) {
    email.classList.add('is-invalid');
    msg += 'Email không hợp lệ.\n'; ok = false;
  } else email.classList.remove('is-invalid');
  if (!pwd.value) {
    pwd.classList.add('is-invalid');
    msg += 'Vui lòng nhập mật khẩu.\n'; ok = false;
  } else pwd.classList.remove('is-invalid');
  if (!ok) {
    alert(msg);
    return false;
  }
  return true;
}
