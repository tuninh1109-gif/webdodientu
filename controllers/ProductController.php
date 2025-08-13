<?php
require_once 'models/Product.php';

class ProductController {
    public function category() {
        global $conn;
        $maloai = isset($_GET['maloai']) ? intval($_GET['maloai']) : 1;
        $math = isset($_GET['math']) ? intval($_GET['math']) : 0;

        // Lấy danh sách thương hiệu của danh mục (có logo)
        $brands = [];
        $sqlBrand = "SELECT * FROM thuonghieu WHERE maloai = $maloai ORDER BY tenthuonghieu ASC";
        $resultBrand = mysqli_query($conn, $sqlBrand);
        while ($row = mysqli_fetch_assoc($resultBrand)) {
            $brands[] = $row;
        }

        // Lọc sản phẩm theo danh mục và thương hiệu nếu có
        $where = "maloai = $maloai";
        if ($math > 0) {
            $where .= " AND math = $math";
        }
        $sqlProduct = "SELECT * FROM sanpham WHERE $where AND trangthai = 1 ORDER BY ngaythem DESC";
        $resultProduct = mysqli_query($conn, $sqlProduct);
        $products = [];
        while ($row = mysqli_fetch_assoc($resultProduct)) {
            $products[] = $row;
        }

        include 'views/product/category.php';
    }

    public function detail() {
        $masp = $_GET['id'] ?? 0;
        $product = Product::getById($masp);
        include 'views/product/detail.php';
    }

    public function search() {
        require_once 'models/LoaiSanPham.php';
        $q = trim($_GET['q'] ?? '');
        $maloai = isset($_GET['maloai']) ? intval($_GET['maloai']) : 0;
        $giatu = isset($_GET['giatu']) ? intval($_GET['giatu']) : 0;
        $giaden = isset($_GET['giaden']) ? intval($_GET['giaden']) : 0;
        $sort = $_GET['sort'] ?? '';
        $loais = LoaiSanPham::getAll();
        $pricerange = Product::getMinMaxPrice();
        $products = [];
        if ($q !== '') {
            $products = Product::searchByName($q);
            // Lọc theo loại
            if ($maloai) {
                $products = array_filter($products, function($p) use ($maloai) {
                    return $p['maloai'] == $maloai;
                });
            }
            // Lọc theo giá
            if ($giatu) {
                $products = array_filter($products, function($p) use ($giatu) {
                    return $p['dongia'] >= $giatu;
                });
            }
            if ($giaden) {
                $products = array_filter($products, function($p) use ($giaden) {
                    return $p['dongia'] <= $giaden;
                });
            }
            // Sắp xếp
            if ($sort == 'price_asc') {
                usort($products, function($a, $b) { return $a['dongia'] - $b['dongia']; });
            } elseif ($sort == 'price_desc') {
                usort($products, function($a, $b) { return $b['dongia'] - $a['dongia']; });
            } elseif ($sort == 'newest') {
                usort($products, function($a, $b) { return strtotime($b['ngaythem']) - strtotime($a['ngaythem']); });
            }
        }
        include 'views/product/search.php';
    }

    public function suggest() {
        $q = trim($_GET['q'] ?? '');
        $result = [];
        if ($q !== '') {
            global $conn;
            $stmt = $conn->prepare("SELECT tensp FROM sanpham WHERE tensp LIKE ? LIMIT 10");
            $like = "%$q%";
            $stmt->bind_param("s", $like);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_assoc()) {
                $result[] = $row['tensp'];
            }
        }
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
    }
}
