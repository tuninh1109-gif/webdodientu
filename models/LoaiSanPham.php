<?php
require_once 'config/db.php';
class LoaiSanPham {
    public static function getAll() {
        global $conn;
        $sql = "SELECT maloai, tenloai FROM loaisp WHERE trangthai=1";
        $result = mysqli_query($conn, $sql);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
}
