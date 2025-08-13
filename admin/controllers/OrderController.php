<?php
include_once(__DIR__ . '/../models/Order.php');

// Hàm ghi log admin
function log_admin_action($noidung) {
    global $conn;
    if (!isset($conn)) {
        $conn = mysqli_connect('localhost', 'root', '', 'do_dien_tu');
        mysqli_set_charset($conn, 'utf8');
    }
    $admin_username = $_SESSION['admin_username'] ?? 'unknown';
    $stmt = $conn->prepare("INSERT INTO log_admin (noidung, admin_username) VALUES (?, ?)");
    $stmt->bind_param("ss", $noidung, $admin_username);
    $stmt->execute();
    $stmt->close();
}

function listOrders() {
    $alert = '';
    if (isset($_GET['duyet'])) {
        $madon = intval($_GET['duyet']);
        // 1 = Đã duyệt
        if (updateOrderStatus($madon, 1)) {
            log_admin_action("Duyệt đơn hàng mã #$madon");
            $alert = '<div class="alert alert-success">Đã duyệt đơn hàng mã <b>' . $madon . '</b> thành công!</div>';
        } else {
            $alert = '<div class="alert alert-danger">Lỗi khi duyệt đơn hàng!</div>';
        }
    } elseif (isset($_GET['dang_giao'])) {
        $madon = intval($_GET['dang_giao']);
        // 2 = Đang giao
        if (updateOrderStatus($madon, 2)) {
            log_admin_action("Chuyển đơn hàng mã #$madon sang trạng thái Đang giao");
            $alert = '<div class="alert alert-primary">Đơn hàng mã <b>' . $madon . '</b> đã chuyển sang trạng thái <b>Đang giao</b>.</div>';
        } else {
            $alert = '<div class="alert alert-danger">Lỗi khi chuyển trạng thái Đang giao!</div>';
        }
    } elseif (isset($_GET['da_giao'])) {
        $madon = intval($_GET['da_giao']);
        // 3 = Đã giao
        if (updateOrderStatus($madon, 3)) {
            log_admin_action("Xác nhận đơn hàng mã #$madon đã giao thành công");
            $alert = '<div class="alert alert-success">Đơn hàng mã <b>' . $madon . '</b> đã xác nhận <b>Đã giao</b>.</div>';
        } else {
            $alert = '<div class="alert alert-danger">Lỗi khi xác nhận đã giao!</div>';
        }
    } elseif (isset($_GET['huydon'])) {
        $madon = intval($_GET['huydon']);
        // 5 = Đã hủy
        if (updateOrderStatus($madon, 5)) {
            log_admin_action("Hủy đơn hàng mã #$madon");
            $alert = '<div class="alert alert-danger">Đã hủy đơn hàng mã <b>' . $madon . '</b>!</div>';
        } else {
            $alert = '<div class="alert alert-danger">Lỗi khi hủy đơn hàng!</div>';
        }
    }
    $orders = getAllOrders();
    include(__DIR__ . '/../views/order/index.php');
}

function viewOrderDetail($id) {
    $order = getOrderById($id);
    $items = getOrderItems($id);
    include(__DIR__ . '/../views/order/detail.php');
}
