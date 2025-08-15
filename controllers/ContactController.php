<?php
require_once __DIR__ . '/../config/db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class ContactController {
    public function index() {
        $this->form();
    }
    public function form() {
        include 'views/contact/form.php';
    }

    public function submit() {
        global $conn;
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $message = $_POST['message'] ?? '';
        $err = [];
        if (!$name) $err[] = 'Vui lòng nhập tên.';
        if (!$email) $err[] = 'Vui lòng nhập email.';
        if (!$message) $err[] = 'Vui lòng nhập nội dung.';
        if (count($err) === 0) {
            $stmt = $conn->prepare('INSERT INTO contact (name, email, phone, message) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('ssss', $name, $email, $phone, $message);
            $stmt->execute();
            $success = true;
        }
        include 'views/contact/form.php';
    }

    // ADMIN: danh sách liên hệ
    public function admin_index() {
        global $conn;
        $result = $conn->query('SELECT * FROM contact ORDER BY created_at DESC');
        include __DIR__ . '/../admin/views/contact/index.php';
    }
    // ADMIN: xem chi tiết
    public function admin_detail() {
        global $conn;
        $id = $_GET['id'] ?? 0;
        $stmt = $conn->prepare('SELECT * FROM contact WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $detail = $stmt->get_result()->fetch_assoc();
        include __DIR__ . '/../admin/views/contact/detail.php';
    }
    // ADMIN: cập nhật trạng thái
    public function admin_update_status() {
        global $conn;
        $id = $_POST['id'] ?? 0;
        $status = $_POST['status'] ?? 'pending';
        $note = $_POST['note'] ?? '';
        $stmt = $conn->prepare('UPDATE contact SET status=?, note=? WHERE id=?');
        $stmt->bind_param('ssi', $status, $note, $id);
        $stmt->execute();
        $success = true;
        // Lấy lại chi tiết để hiển thị thông báo
        $stmt2 = $conn->prepare('SELECT * FROM contact WHERE id=?');
        $stmt2->bind_param('i', $id);
        $stmt2->execute();
        $detail = $stmt2->get_result()->fetch_assoc();
        include __DIR__ . '/../admin/views/contact/detail.php';
    }

    // ADMIN: gửi email phản hồi (dùng PHPMailer với SMTP Gmail)
    public function contact_send_mail() {
        global $conn;
        // Tải PHPMailer nếu chưa có
        require_once __DIR__ . '/../libs/PHPMailer/src/PHPMailer.php';
        require_once __DIR__ . '/../libs/PHPMailer/src/SMTP.php';
        require_once __DIR__ . '/../libs/PHPMailer/src/Exception.php';
        $id = $_POST['id'] ?? 0;
        $subject = $_POST['subject'] ?? '';
        $body = $_POST['body'] ?? '';
        // Lấy email khách
        $stmt = $conn->prepare('SELECT * FROM contact WHERE id=?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $detail = $stmt->get_result()->fetch_assoc();
        $mail_success = false;
        $mail_error = '';
        if ($detail && $detail['email']) {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            try {
                // Cấu hình SMTP Gmail
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'abc@gmail.com'; 
                $mail->Password = 'xyz';    
                $mail->setFrom('abc@gmail.com', 'HihiMart');       
                $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->CharSet = 'UTF-8';
                $mail->addAddress($detail['email'], $detail['name']);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->isHTML(false);
                $mail->send();
                $mail_success = true;
            } catch (\Exception $e) {
                $mail_error = 'Không gửi được email: ' . $mail->ErrorInfo;
            }
        } else {
            $mail_error = 'Không tìm thấy email khách hàng.';
        }
        include __DIR__ . '/../admin/views/contact/detail.php';
    }
}
