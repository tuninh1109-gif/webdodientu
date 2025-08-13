<?php
require_once 'models/Product.php';

class CartController {
    // Hàm cập nhật tổng số lượng sản phẩm trong giỏ
    private function updateCartQty() {
        $_SESSION['cart_qty'] = 0;
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $_SESSION['cart_qty'] += $item['soluong'];
            }
        }
    }
    public function index() {
        include 'views/cart/index.php';
    }

    public function add() {
        $masp = $_POST['masp'];
        $soluong = $_POST['soluong'];

        $product = Product::getById($masp);
        if (!$product) {
            $this->updateCartQty();
            header("Location: /do_dien_tu/index.php?controller=cart&action=index");
            exit;
        }

        // Lấy giá ưu tiên sale nếu có
        $now = date('Y-m-d H:i:s');
        $sale_price = null;
        $sql = "SELECT sp.sale_price FROM sale_products sp JOIN sales s ON sp.sale_id = s.id WHERE sp.product_id = $masp AND s.status = 1 AND s.start_time <= '$now' AND s.end_time >= '$now' LIMIT 1";
        $result = mysqli_query($GLOBALS['conn'], $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            $sale_price = $row['sale_price'];
        }
        $price = $sale_price !== null ? $sale_price : $product['dongia'];

        // Nếu sản phẩm đã có trong giỏ
        if (isset($_SESSION['cart'][$masp])) {
            $_SESSION['cart'][$masp]['soluong'] += $soluong;
            $_SESSION['cart'][$masp]['dongia'] = $price; // Cập nhật giá nếu có thay đổi
        } else {
            $_SESSION['cart'][$masp] = [
                'masp' => $masp,
                'tensp' => $product['tensp'],
                'dongia' => $price,
                'soluong' => $soluong,
                'hinhanh' => $product['hinhanh'], // Thêm trường hình ảnh
            ];
        }
        $this->updateCartQty();
        header("Location: /do_dien_tu/index.php?controller=cart&action=index");
    }

    public function remove() {
        $masp = $_GET['id'];
        unset($_SESSION['cart'][$masp]);
        $this->updateCartQty();
        header("Location: /do_dien_tu/index.php?controller=cart&action=index");
    }

    public function clear() {
        unset($_SESSION['cart']);
        $this->updateCartQty();
        header("Location: /do_dien_tu/index.php?controller=cart&action=index");
    }

    // Tăng số lượng sản phẩm
    public function increase() {
        $masp = $_GET['id'];
        if (isset($_SESSION['cart'][$masp])) {
            $_SESSION['cart'][$masp]['soluong']++;
        }
        $this->updateCartQty();
        header("Location: /do_dien_tu/index.php?controller=cart&action=index");
        exit();
    
    }

    // Giảm số lượng sản phẩm
    public function decrease() {
        $masp = $_GET['id'];
        if (isset($_SESSION['cart'][$masp])) {
            $_SESSION['cart'][$masp]['soluong']--;
            if ($_SESSION['cart'][$masp]['soluong'] <= 0) {
                unset($_SESSION['cart'][$masp]);
            }
        }
        $this->updateCartQty();
        header("Location: /do_dien_tu/index.php?controller=cart&action=index");
        exit();
    }
}
