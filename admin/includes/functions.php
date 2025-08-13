<?php
// Hàm ghi log thao tác admin
function log_admin_action($conn, $message) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $username = isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'unknown';
    $stmt = $conn->prepare("INSERT INTO log_admin (noidung, thoigian, admin_username) VALUES (?, NOW(), ?)");
    if ($stmt) {
        $stmt->bind_param("ss", $message, $username);
        $stmt->execute();
        $stmt->close();
    }
}
