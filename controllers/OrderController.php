<?php
require_once 'config/db.php';

class OrderController {
    public function checkout() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $tongtien = 0;
            $makh = null;
            $ten_nguoinhan = '';
            $diachi_nhan = '';
            $sdt_nhan = '';
            $luu_diachi = isset($_POST['luu_diachi']);
            $diachi_saved = isset($_POST['diachi_saved']) ? intval($_POST['diachi_saved']) : 0;

            // Nếu user đã đăng nhập
            if (isset($_SESSION['user']) && !empty($_SESSION['user']['makh'])) {
                $makh = intval($_SESSION['user']['makh']);
                if ($diachi_saved > 0) {
                    // Lấy thông tin địa chỉ đã lưu
                    $sql = "SELECT * FROM diachi_nhanhang WHERE id = $diachi_saved AND makh = $makh";
                    $rs = mysqli_query($GLOBALS['conn'], $sql);
                    $row = mysqli_fetch_assoc($rs);
                    if ($row) {
                        $ten_nguoinhan = $row['ten_nguoinhan'];
                        $diachi_nhan = $row['diachi'];
                        $sdt_nhan = $row['sodienthoai'];
                    } else {
                        // fallback nếu không tìm thấy
                        $ten_nguoinhan = $_POST['tenkh'];
                        $diachi_nhan = $_POST['diachi'];
                        $sdt_nhan = $_POST['sodienthoai'];
                    }
                } else {
                    // Nhập mới
                    $ten_nguoinhan = $_POST['tenkh'];
                    $diachi_nhan = $_POST['diachi'];
                    $sdt_nhan = $_POST['sodienthoai'];
                    // Nếu tích lưu địa chỉ thì insert vào bảng địa chỉ nhận hàng
                    if ($luu_diachi) {
                        $ten_nguoinhan_sql = mysqli_real_escape_string($GLOBALS['conn'], $ten_nguoinhan);
                        $diachi_nhan_sql = mysqli_real_escape_string($GLOBALS['conn'], $diachi_nhan);
                        $sdt_nhan_sql = mysqli_real_escape_string($GLOBALS['conn'], $sdt_nhan);
                        mysqli_query($GLOBALS['conn'], "INSERT INTO diachi_nhanhang (makh, ten_nguoinhan, diachi, sodienthoai) VALUES ($makh, '$ten_nguoinhan_sql', '$diachi_nhan_sql', '$sdt_nhan_sql')");
                    }
                }
            } else {
                // Nếu chưa đăng nhập thì tạo khách mới như cũ
                $tenkh = $_POST['tenkh'];
                $email = $_POST['email'];
                $diachi = $_POST['diachi'];
                $sodienthoai = $_POST['sodienthoai'];
                $sql_kh = "INSERT INTO khachhang (tenkh, email, diachi, sodienthoai) VALUES ('$tenkh', '$email', '$diachi', '$sodienthoai')";
                mysqli_query($GLOBALS['conn'], $sql_kh);
                $makh = mysqli_insert_id($GLOBALS['conn']);
                $ten_nguoinhan = $tenkh;
                $diachi_nhan = $diachi;
                $sdt_nhan = $sodienthoai;
            }

            // Tính tổng đơn
            foreach ($_SESSION['cart'] as $item) {
                $tongtien += $item['dongia'] * $item['soluong'];
            }

            // Lưu đơn hàng (bổ sung thông tin người nhận)
            $ten_nguoinhan_sql = mysqli_real_escape_string($GLOBALS['conn'], $ten_nguoinhan);
            $diachi_nhan_sql = mysqli_real_escape_string($GLOBALS['conn'], $diachi_nhan);
            $sdt_nhan_sql = mysqli_real_escape_string($GLOBALS['conn'], $sdt_nhan);
            $sql_dh = "INSERT INTO donhang (makh, ten_nguoinhan, diachi_nhan, sdt_nhan, tongtien) VALUES ($makh, '$ten_nguoinhan_sql', '$diachi_nhan_sql', '$sdt_nhan_sql', $tongtien)";
            mysqli_query($GLOBALS['conn'], $sql_dh);
            $madon = mysqli_insert_id($GLOBALS['conn']);

            // Lưu chi tiết + trừ tồn kho
            foreach ($_SESSION['cart'] as $item) {
                $masp = $item['masp'];
                $soluong = $item['soluong'];
                $dongia = $item['dongia'];

                // Lưu chi tiết đơn hàng
                $sql_ct = "INSERT INTO chitietdonhang (madon, masp, soluong, dongia) VALUES ($madon, $masp, $soluong, $dongia)";
                mysqli_query($GLOBALS['conn'], $sql_ct);

                // Trừ kho
                $sql_update = "UPDATE sanpham SET soluong = soluong - $soluong WHERE masp = $masp AND soluong >= $soluong";
                mysqli_query($GLOBALS['conn'], $sql_update);
            }

            unset($_SESSION['cart']); // xoá giỏ hàng

            // Chuyển hướng tới trang chi tiết đơn hàng ngay sau khi đặt hàng
            header("Location: /do_dien_tu/index.php?controller=order&action=order_detail&madon=$madon");
            exit;
        }

        include 'views/order/checkout.php';
    }

    public function thankyou() {
        include 'views/order/thankyou.php';
    }

    // Xác nhận đã nhận hàng, cập nhật trạng thái sang 'Đã giao'
    public function confirm_received() {
        if (isset($_GET['madon']) && isset($_SESSION['user'])) {
            $madon = intval($_GET['madon']);
            $makh = intval($_SESSION['user']['makh']);
            // Chỉ cho phép xác nhận đơn của chính mình
            $sql = "UPDATE donhang SET trangthai = 3 WHERE madon = $madon AND makh = $makh";
            mysqli_query($GLOBALS['conn'], $sql);
        }
        // Quay lại trang chi tiết đơn hàng
        header("Location: /do_dien_tu/index.php?controller=order&action=order_detail&madon=$madon");
        exit;
    }

    public function myorders() {
        // Xử lý hủy đơn nếu có action
        if (isset($_GET['action']) && $_GET['action'] === 'huydon' && isset($_GET['madon']) && isset($_SESSION['user'])) {
            $madon = intval($_GET['madon']);
            $makh = intval($_SESSION['user']['makh']);
            // Kiểm tra trạng thái đơn hiện tại
            $sql = "SELECT trangthai FROM donhang WHERE madon = $madon AND makh = $makh";
            $rs = mysqli_query($GLOBALS['conn'], $sql);
            $row = mysqli_fetch_assoc($rs);
            if ($row && intval($row['trangthai']) === 0) {
                // Chỉ cho phép hủy nếu trạng thái là 0
                mysqli_query($GLOBALS['conn'], "UPDATE donhang SET trangthai = 5 WHERE madon = $madon AND makh = $makh");
                $_SESSION['alert_myorders'] = '<div class="alert alert-success">Đã hủy đơn hàng mã <b>' . $madon . '</b>!</div>';
            } else {
                $_SESSION['alert_myorders'] = '<div class="alert alert-danger">Không thể hủy đơn hàng này!</div>';
            }
            header('Location: index.php?controller=order&action=myorders');
            exit;
        }
        include 'views/order/myorders.php';
    }

    public function order_detail() {
        include 'views/order/order_detail.php';
    }
}
