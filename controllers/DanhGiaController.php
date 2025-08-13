<?php
require_once __DIR__ . '/../config/db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class DanhGiaController {
    // Hiển thị danh sách đánh giá
    public function admin_index() {
        global $conn;
        $result = $conn->query('SELECT * FROM danhgia ORDER BY thoigian DESC');
        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
        include __DIR__ . '/../admin/views/danhgia/index.php';
    }

    // Cập nhật phản hồi admin
    public function admin_reply() {
        global $conn;
        $id = $_POST['id'] ?? 0;
        $admin_reply = $_POST['admin_reply'] ?? '';
        // Lấy đánh giá cũ để kiểm tra trạng thái phản hồi
        $stmtOld = $conn->prepare('SELECT * FROM danhgia WHERE id=?');
        $stmtOld->bind_param('i', $id);
        $stmtOld->execute();
        $resultOld = $stmtOld->get_result();
        $oldReview = $resultOld->fetch_assoc();
        $stmtOld->close();
        // Cập nhật phản hồi
        $stmt = $conn->prepare('UPDATE danhgia SET admin_reply=? WHERE id=?');
        $stmt->bind_param('si', $admin_reply, $id);
        $stmt->execute();
        // Nếu trước đó chưa có phản hồi và bây giờ có, gửi email cho khách
        if (empty($oldReview['admin_reply']) && !empty($admin_reply)) {
            // Lấy email khách hàng
            $makh = $oldReview['makh'];
            $stmtKH = $conn->prepare('SELECT email, tenkh FROM khachhang WHERE makh=?');
            $stmtKH->bind_param('s', $makh);
            $stmtKH->execute();
            $resultKH = $stmtKH->get_result();
            $kh = $resultKH->fetch_assoc();
            $stmtKH->close();
            if ($kh && !empty($kh['email'])) {
                $to = $kh['email'];
                $tenkh = $kh['tenkh'];
                // Lấy thông tin sản phẩm để gửi link
                $masp = $oldReview['masp'];
                $stmtSP = $conn->prepare('SELECT tensp FROM sanpham WHERE masp=?');
                $stmtSP->bind_param('s', $masp);
                $stmtSP->execute();
                $resultSP = $stmtSP->get_result();
                $sp = $resultSP->fetch_assoc();
                $stmtSP->close();
                $productName = $sp ? $sp['tensp'] : '';
                $productUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/do_dien_tu/index.php?page=product_detail&id=' . $masp;
                // Gửi email
                require_once __DIR__ . '/../public/PHPMailer/PHPMailer.php';
                require_once __DIR__ . '/../public/PHPMailer/SMTP.php';
                require_once __DIR__ . '/../public/PHPMailer/Exception.php';
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'tuninh1109@gmail.com';
                    $mail->Password = 'lazyiboazbpomzmw';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                    $mail->setFrom('tuninh1109@gmail.com', 'HihiMart');
                    $mail->addAddress($to, $tenkh);
                    $mail->isHTML(true);
                    $mail->Subject = 'Shop đã phản hồi đánh giá của bạn!';
                    $mail->Body = '<p>Xin chào <b>' . htmlspecialchars($tenkh) . '</b>,</p>' .
                        '<p>Cảm ơn bạn đã đánh giá sản phẩm <b>' . htmlspecialchars($productName) . '</b> tại HihiMart.</p>' .
                        '<p>Shop vừa phản hồi ý kiến của bạn. Vui lòng xem chi tiết tại: <a href="' . $productUrl . '">Xem sản phẩm</a></p>' .
                        '<hr><div style="background:#f8f9fa;padding:10px;border-radius:8px;"><b>Phản hồi từ shop:</b><br>' . nl2br(htmlspecialchars($admin_reply)) . '</div>';
                    $mail->CharSet = 'UTF-8';
                    $mail->send();
                } catch (Exception $e) {
                    // Có thể log lỗi nếu cần
                }
            }
        }
        header('Location: index.php?page=danhgia_admin&reply=success');
        exit;
    }
}
