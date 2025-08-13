<?php
class SaleProduct {
    public static function allBySale($sale_id) {
        global $conn;
        $sql = "SELECT sp.*, p.tensp, p.hinhanh FROM sale_products sp JOIN sanpham p ON sp.product_id = p.masp WHERE sp.sale_id = $sale_id";
        return mysqli_query($conn, $sql);
    }
    public static function find($id) {
        global $conn;
        $sql = "SELECT * FROM sale_products WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($result);
    }
    public static function create($data) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO sale_products (sale_id, product_id, sale_price, quantity) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiii", $data['sale_id'], $data['product_id'], $data['sale_price'], $data['quantity']);
        $stmt->execute();
        $stmt->close();
        return $conn->insert_id;
    }
    public static function update($id, $data) {
        global $conn;
        $stmt = $conn->prepare("UPDATE sale_products SET sale_price=?, quantity=? WHERE id=?");
        $stmt->bind_param("iii", $data['sale_price'], $data['quantity'], $id);
        $stmt->execute();
        $stmt->close();
    }
    public static function delete($id) {
        global $conn;
        $sql = "DELETE FROM sale_products WHERE id = $id";
        return mysqli_query($conn, $sql);
    }
    public static function deleteBySale($sale_id) {
        global $conn;
        $sql = "DELETE FROM sale_products WHERE sale_id = $sale_id";
        return mysqli_query($conn, $sql);
    }
}
