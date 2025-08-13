<?php
class Sale {
    public static function all() {
        global $conn;
        $sql = "SELECT * FROM sales ORDER BY start_time DESC";
        return mysqli_query($conn, $sql);
    }
    public static function find($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM sales WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    }

    // Lấy chương trình sale đang chạy hiện tại
    public static function getActive() {
        global $conn;
        $now = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("SELECT * FROM sales WHERE status=1 AND start_time <= ? AND end_time >= ? ORDER BY end_time ASC LIMIT 1");
        $stmt->bind_param("ss", $now, $now);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    }

    // Lấy tất cả sản phẩm sale của 1 chương trình
    public static function getSaleProducts($sale_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT sp.*, p.tensp, p.hinhanh, p.dongia FROM sale_products sp JOIN sanpham p ON p.masp = sp.product_id WHERE sp.sale_id = ? AND sp.quantity > 0 ORDER BY sp.id ASC");
        $stmt->bind_param("i", $sale_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    // Thêm mới chương trình sale
    public static function create($data) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO sales (title, description, start_time, end_time, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $data['title'], $data['description'], $data['start_time'], $data['end_time'], $data['status']);
        $stmt->execute();
        $stmt->close();
        return $conn->insert_id;
    }

    // Cập nhật chương trình sale
    public static function update($id, $data) {
        global $conn;
        $stmt = $conn->prepare("UPDATE sales SET title=?, description=?, start_time=?, end_time=?, status=? WHERE id=?");
        $stmt->bind_param("ssssii", $data['title'], $data['description'], $data['start_time'], $data['end_time'], $data['status'], $id);
        $stmt->execute();
        $stmt->close();
    }

    // Xóa chương trình sale
    public static function delete($id) {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM sales WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        return true;
    }
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }
    public static function create($data) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO sales (title, description, start_time, end_time, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $data['title'], $data['description'], $data['start_time'], $data['end_time'], $data['status']);
        $stmt->execute();
        $stmt->close();
        return $conn->insert_id;
    }
    public static function update($id, $data) {
        global $conn;
        $stmt = $conn->prepare("UPDATE sales SET title=?, description=?, start_time=?, end_time=?, status=? WHERE id=?");
        $stmt->bind_param("ssssii", $data['title'], $data['description'], $data['start_time'], $data['end_time'], $data['status'], $id);
        $stmt->execute();
        $stmt->close();
    }
    public static function delete($id) {
        global $conn;
        $sql = "DELETE FROM sales WHERE id = $id";
        return mysqli_query($conn, $sql);
    }
}
