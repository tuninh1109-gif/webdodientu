<?php
class ProductPromotion {
    public static function getByProduct($masp) {
        global $conn;
        $sql = "SELECT * FROM sanpham_khuyenmai WHERE masp = $masp";
        return mysqli_query($conn, $sql);
    }
    public static function getOne($id) {
        global $conn;
        $sql = "SELECT * FROM sanpham_khuyenmai WHERE id = $id";
        return mysqli_fetch_assoc(mysqli_query($conn, $sql));
    }
    public static function add($masp, $noidung, $loai = null, $icon = null, $tg_batdau = null, $tg_ketthuc = null, $khu_vuc = null) {
        global $conn;
        $stmt = mysqli_prepare($conn, "INSERT INTO sanpham_khuyenmai (masp, noidung, loai, icon, thoi_gian_bat_dau, thoi_gian_ket_thuc, khu_vuc) VALUES (?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "issssss", $masp, $noidung, $loai, $icon, $tg_batdau, $tg_ketthuc, $khu_vuc);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    public static function update($id, $noidung, $loai = null, $icon = null, $tg_batdau = null, $tg_ketthuc = null, $khu_vuc = null) {
        global $conn;
        $stmt = mysqli_prepare($conn, "UPDATE sanpham_khuyenmai SET noidung=?, loai=?, icon=?, thoi_gian_bat_dau=?, thoi_gian_ket_thuc=?, khu_vuc=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ssssssi", $noidung, $loai, $icon, $tg_batdau, $tg_ketthuc, $khu_vuc, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    public static function deleteByProduct($masp) {
        global $conn;
        $sql = "DELETE FROM sanpham_khuyenmai WHERE masp = $masp";
        mysqli_query($conn, $sql);
    }
}
