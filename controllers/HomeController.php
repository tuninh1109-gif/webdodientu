<?php
require_once 'models/Product.php';
require_once 'config/db.php'; // Thêm dòng này để có $conn nếu cần

class HomeController {
    public function index() {
        global $conn;
        // Banner
        $banners = mysqli_query($conn, "SELECT * FROM banner WHERE status = 'active'");
$bannerArr = [];
while ($row = mysqli_fetch_assoc($banners)) $bannerArr[] = $row;
        // Sản phẩm mới
        $products_new = [];
        $result_new = Product::getLatest(8);
        while ($row = mysqli_fetch_assoc($result_new)) {
            $products_new[] = $row;
        }
        // Sản phẩm nổi bật (ví dụ: có field hot=1)
        $products_hot = [];
        $result_hot = mysqli_query($conn, "SELECT * FROM sanpham WHERE hot=1 ORDER BY ngaythem DESC LIMIT 8");
        while ($row = mysqli_fetch_assoc($result_hot)) {
            $products_hot[] = $row;
        }
        // Tivi
        $products_tivi = [];
        $result_tivi = Product::getByCategory(1); // 1: mã loại tivi
        $count = 0;
        while (($row = mysqli_fetch_assoc($result_tivi)) && $count < 8) {
            $products_tivi[] = $row;
            $count++;
        }
        // Tủ lạnh
        $products_tulanh = [];
        $result_tulanh = Product::getByCategory(2); // 2: mã loại tủ lạnh
        $count = 0;
        while (($row = mysqli_fetch_assoc($result_tulanh)) && $count < 8) {
            $products_tulanh[] = $row;
            $count++;
        }
        // Máy giặt
        $products_maygiat = [];
        $result_maygiat = Product::getByCategory(3); // 3: mã loại máy giặt
        $count = 0;
        while (($row = mysqli_fetch_assoc($result_maygiat)) && $count < 8) {
            $products_maygiat[] = $row;
            $count++;
        }
        // Điều hòa
        $products_dieuhoa = [];
        $result_dieuhoa = Product::getByCategory(4); // 4: mã loại điều hòa
        $count = 0;
        while (($row = mysqli_fetch_assoc($result_dieuhoa)) && $count < 8) {
            $products_dieuhoa[] = $row;
            $count++;
        }
        // Sản phẩm sale chuyên nghiệp
        $products_sale = [];
        $result_sale = Product::getSaleProducts(10);
        while ($row = mysqli_fetch_assoc($result_sale)) {
            $products_sale[] = $row;
        }
        // Điện thoại
        $products_dienthoai = [];
        $result_dienthoai = Product::getByCategory(5); // 5: mã loại điện thoại
        $count = 0;
        while (($row = mysqli_fetch_assoc($result_dienthoai)) && $count < 8) {
            $products_dienthoai[] = $row;
            $count++;
        }
        // Máy tính xách tay
        $products_laptop = [];
        $result_laptop = Product::getByCategory(6); // 6: mã loại laptop
        $count = 0;
        while (($row = mysqli_fetch_assoc($result_laptop)) && $count < 8) {
            $products_laptop[] = $row;
            $count++;
        }
        // Sản phẩm sale nổi bật
        $products_sale = [];
        $result_sale = Product::getSaleProducts(12); // lấy tối đa 12 sản phẩm sale
        while ($row = mysqli_fetch_assoc($result_sale)) {
            $products_sale[] = $row;
        }
        // Gọi view
        include 'views/home/index.php';
    }
}

