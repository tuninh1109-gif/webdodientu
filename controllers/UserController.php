<?php
require_once 'models/KhachHang.php';

class UserController {
    public function login() {
        $error = '';
        if (isset($_POST['login'])) {
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $user = KhachHang::findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
$_SESSION['user_id'] = $user['makh'];
                header("Location: /do_dien_tu/index.php");
                exit();
            } else {
                $error = "Sai email hoặc mật khẩu!";
            }
        }
        include 'views/user/login.php';
    }

    public function register() {
        $error = $success = '';
        if (isset($_POST['register'])) {
            $tenkh = trim($_POST['tenkh']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $repassword = $_POST['repassword'] ?? '';
            $diachi = trim($_POST['diachi']);
            $sodienthoai = trim($_POST['sodienthoai']);
            
            // Validation server-side
            if (strlen($tenkh) < 2) {
                $error = "Họ tên phải từ 2 ký tự trở lên!";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email không hợp lệ!";
            } elseif (strlen($password) < 6) {
                $error = "Mật khẩu phải từ 6 ký tự trở lên!";
            } elseif ($password !== $repassword) {
                $error = "Mật khẩu nhập lại không khớp!";
            } elseif (!preg_match('/^\d{8,15}$/', $sodienthoai)) {
                $error = "Số điện thoại không hợp lệ (8-15 chữ số)!";
            } elseif (strlen($diachi) < 3) {
                $error = "Địa chỉ phải từ 3 ký tự trở lên!";
            } elseif (KhachHang::findByEmail($email)) {
                $error = "Email đã tồn tại!";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                
                // Debug logging
                error_log("UserController::register - Attempting to create user: $email");
                error_log("UserController::register - Data: tenkh=$tenkh, diachi=$diachi, sodienthoai=$sodienthoai");
                
                $create_result = KhachHang::create($tenkh, $email, $hash, $diachi, $sodienthoai);
                
                if ($create_result) {
                    error_log("UserController::register - User created successfully: $email");
                    $success = "Đăng ký thành công! Bạn có thể đăng nhập ngay.";
                } else {
                    error_log("UserController::register - Failed to create user: $email");
                    global $conn;
                    if ($conn && $conn->error) {
                        error_log("UserController::register - MySQL Error: " . $conn->error);
                        $error = "Lỗi database: " . $conn->error;
                    } else {
                        $error = "Có lỗi xảy ra khi tạo tài khoản, vui lòng thử lại.";
                    }
                }
            }
        }
        include 'views/user/register.php';
    }

    public function orders() {
        if (!isset($_SESSION['user'])) {
            header('Location: /do_dien_tu/index.php?controller=user&action=login');
            exit;
        }
        include 'views/user/orders.php';
    }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        unset($_SESSION['user']);
        session_destroy();
        header("Location: /do_dien_tu/index.php");
        exit();
    }
}
