<?php
class ProductService {
    public static function getByProduct($masp) {
        global $conn;
        $sql = "SELECT * FROM sanpham_dichvu WHERE masp = $masp";
        return mysqli_query($conn, $sql);
    }
    public static function getOne($id) {
        global $conn;
        $sql = "SELECT * FROM sanpham_dichvu WHERE id = $id";
        return mysqli_fetch_assoc(mysqli_query($conn, $sql));
    }
    public static function add($masp, $ten_goi, $mota, $giacu, $giamoi, $dacdiem) {
        global $conn;
        $stmt = mysqli_prepare($conn, "INSERT INTO sanpham_dichvu (masp, ten_goi, mota, giacu, giamoi, dacdiem) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "issiii", $masp, $ten_goi, $mota, $giacu, $giamoi, $dacdiem);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    public static function update($id, $ten_goi, $mota, $giacu, $giamoi, $dacdiem) {
        global $conn;
        $stmt = mysqli_prepare($conn, "UPDATE sanpham_dichvu SET ten_goi=?, mota=?, giacu=?, giamoi=?, dacdiem=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssiiii", $ten_goi, $mota, $giacu, $giamoi, $dacdiem, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    public static function deleteByProduct($masp) {
        global $conn;
        $sql = "DELETE FROM sanpham_dichvu WHERE masp = $masp";
        mysqli_query($conn, $sql);
    }
}
