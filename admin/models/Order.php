<?php
include_once(__DIR__ . '/../../config/db.php');

function getAllOrders() {
    global $conn;
    $sql = "SELECT * FROM donhang ORDER BY ngaydat DESC";
    return mysqli_query($conn, $sql);
}

function getOrderById($id) {
    global $conn;
    $sql = "SELECT * FROM donhang WHERE madon = $id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function getOrderItems($id) {
    global $conn;
    $sql = "SELECT ctdh.*, sp.tensp 
            FROM chitietdonhang ctdh
            JOIN sanpham sp ON ctdh.masp = sp.masp
            WHERE ctdh.madon = $id";
    return mysqli_query($conn, $sql);
}

// Cập nhật trạng thái đơn hàng
function updateOrderStatus($madon, $status) {
    global $conn;
    $madon = intval($madon);
    $stmt = mysqli_prepare($conn, "UPDATE donhang SET trangthai = ? WHERE madon = ?");
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, "si", $status, $madon);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}