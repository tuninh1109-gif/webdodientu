<?php
require_once 'config/db.php';

class KhachHang {
    public static function findByEmail($email) {
        global $conn;
        try {
            $stmt = $conn->prepare("SELECT * FROM khachhang WHERE email=? LIMIT 1");
            if (!$stmt) {
                error_log("Prepare failed: " . $conn->error);
                return false;
            }
            
            $stmt->bind_param("s", $email);
            if (!$stmt->execute()) {
                error_log("Execute failed: " . $stmt->error);
                return false;
            }
            
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        } catch (Exception $e) {
            error_log("KhachHang::findByEmail error: " . $e->getMessage());
            return false;
        }
    }
    
    public static function create($tenkh, $email, $password, $diachi, $sodienthoai) {
        global $conn;
        
        // Debug logging
        error_log("KhachHang::create called with: tenkh=$tenkh, email=$email, diachi=$diachi, sodienthoai=$sodienthoai");
        
        if (!$conn) {
            error_log("KhachHang::create - No database connection!");
            return false;
        }
        
        try {
            // Thêm cột trangthai với giá trị mặc định là 1 (active)
            $sql = "INSERT INTO khachhang (tenkh, email, password, diachi, sodienthoai, trangthai) VALUES (?, ?, ?, ?, ?, ?)";
            error_log("KhachHang::create - SQL: $sql");
            
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                error_log("KhachHang::create - Prepare failed: " . $conn->error);
                return false;
            }
            
            $trangthai = 1;
            $stmt->bind_param("sssssi", $tenkh, $email, $password, $diachi, $sodienthoai, $trangthai);
            
            if (!$stmt->execute()) {
                error_log("KhachHang::create - Execute failed: " . $stmt->error);
                error_log("KhachHang::create - MySQL errno: " . $stmt->errno);
                return false;
            }
            
            $insert_id = $conn->insert_id;
            error_log("KhachHang::create - Success! Insert ID: $insert_id");
            
            $stmt->close();
            return true;
            
        } catch (Exception $e) {
            error_log("KhachHang::create - Exception: " . $e->getMessage());
            return false;
        }
    }
    
    // Method để debug - kiểm tra kết nối và bảng
    public static function checkDatabase() {
        global $conn;
        $result = [];
        
        // Kiểm tra kết nối
        $result['connection'] = $conn ? true : false;
        
        // Kiểm tra bảng tồn tại
        $query = "SHOW TABLES LIKE 'khachhang'";
        $check = mysqli_query($conn, $query);
        $result['table_exists'] = mysqli_num_rows($check) > 0;
        
        // Kiểm tra cấu trúc bảng
        if ($result['table_exists']) {
            $query = "DESCRIBE khachhang";
            $structure = mysqli_query($conn, $query);
            $result['columns'] = [];
            while ($row = mysqli_fetch_assoc($structure)) {
                $result['columns'][] = $row['Field'];
            }
        }
        
        return $result;
    }
}
