<?php
require_once 'config/db.php';

class Product {
    public static function getLatest($limit = 8) {
        global $conn;
        $sql = "SELECT * FROM sanpham ORDER BY ngaythem DESC LIMIT $limit";
        return mysqli_query($conn, $sql);
    }

    public static function getByCategory($maloai) {
        global $conn;
        $sql = "SELECT * FROM sanpham WHERE maloai = $maloai ORDER BY ngaythem DESC";
        return mysqli_query($conn, $sql);
    }

    public static function getById($masp) {
        global $conn;
        $sql = "SELECT * FROM sanpham WHERE masp = $masp";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    public static function searchByName($keyword) {
        global $conn;
        $sql = "SELECT * FROM sanpham WHERE tensp LIKE ? OR mota LIKE ? ORDER BY ngaythem DESC";
        $stmt = $conn->prepare($sql);
        $like = "%" . $keyword . "%";
        $stmt->bind_param("ss", $like, $like);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }

    public static function getMinMaxPrice() {
        global $conn;
        $sql = "SELECT MIN(dongia) as min_price, MAX(dongia) as max_price FROM sanpham";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($result);
    }

    // Lấy sản phẩm đang sale chuyên nghiệp
    public static function getSaleProducts($limit = 10) {
        global $conn;
        $now = date('Y-m-d H:i:s');
        $sql = "SELECT p.*, sp.sale_price, sp.quantity, s.start_time, s.end_time
                FROM sale_products sp
                JOIN sales s ON sp.sale_id = s.id
                JOIN sanpham p ON sp.product_id = p.masp
                WHERE s.status = 1
                  AND s.start_time <= '$now'
                  AND s.end_time >= '$now'
                ORDER BY s.end_time ASC
                LIMIT $limit";
        if (isset($_GET['debug_sale']) && $_GET['debug_sale'] == 1) {
            echo "<pre style='background:#ffe;border:1px solid #ccc;padding:8px;'>";
            echo "NOW: $now\n";
            echo "SQL: $sql";
            echo "</pre>";
        }
        return mysqli_query($conn, $sql);
    }
}

