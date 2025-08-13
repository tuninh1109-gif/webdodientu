<?php
// Cấu hình kết nối CSDL
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'do_dien_tu';

// Tạo kết nối
$conn = mysqli_connect($host, $user, $password, $database);

// Cài đặt bảng mã utf8
mysqli_set_charset($conn, 'utf8');

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
?>
