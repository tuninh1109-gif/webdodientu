<?php
session_start();
include(__DIR__ . '/../../../config/db.php');

// Lấy ID sản phẩm từ URL và kiểm tra hợp lệ
$masp = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($masp > 0) {
    // Lấy thông tin sản phẩm trước khi xóa (để xóa ảnh)
    $stmt = $conn->prepare("SELECT hinhanh FROM sanpham WHERE masp = ?");
    $stmt->bind_param("i", $masp);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    
    if ($product) {
        // Xóa ảnh sản phẩm nếu tồn tại
        if (!empty($product['hinhanh'])) {
            $imagePath = __DIR__ . "/../../../public/assets/images/" . $product['hinhanh'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        // Xóa sản phẩm khỏi CSDL
        $stmt = $conn->prepare("DELETE FROM sanpham WHERE masp = ?");
        $stmt->bind_param("i", $masp);
        
        if ($stmt->execute()) {
            // Xóa thành công
            header("Location: /do_dien_tu/admin/index.php?page=product&msg=delete_success");
        } else {
            // Xóa thất bại
            header("Location: /do_dien_tu/admin/index.php?page=product&msg=delete_error");
        }
    } else {
        // Không tìm thấy sản phẩm
        header("Location: /do_dien_tu/admin/index.php?page=product&msg=not_found");
    }
} else {
    // ID không hợp lệ
    header("Location: /do_dien_tu/admin/index.php?page=product&msg=invalid_id");
}

exit;
?>