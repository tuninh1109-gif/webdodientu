<?php
session_start();
require_once 'config/db.php';

echo "<h2>🔑 Kiểm tra và Reset Password</h2>";

// Lấy thông tin user đầu tiên
$result = mysqli_query($conn, "SELECT * FROM khachhang WHERE email = 'tuninh@gmail.com' LIMIT 1");
$user = mysqli_fetch_assoc($result);

if ($user) {
    echo "<h3>👤 User hiện tại:</h3>";
    echo "ID: " . $user['makh'] . "<br>";
    echo "Tên: " . $user['tenkh'] . "<br>";
    echo "Email: " . $user['email'] . "<br>";
    echo "Password hash: " . $user['password'] . "<br>";
    echo "Trạng thái: " . $user['trangthai'] . "<br>";
    
    // Kiểm tra xem password có phải là hash không
    if (strlen($user['password']) < 60) {
        echo "<br>⚠️ Password có vẻ không được hash đúng cách!<br>";
        echo "💡 Đang cập nhật password thành '123456' với hash đúng...<br>";
        
        $new_password = password_hash("123456", PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE khachhang SET password = ? WHERE makh = ?");
        $stmt->bind_param("si", $new_password, $user['makh']);
        
        if ($stmt->execute()) {
            echo "✅ Đã cập nhật password thành công!<br>";
            echo "🔑 Bây giờ bạn có thể đăng nhập với:<br>";
            echo "📧 Email: tuninh@gmail.com<br>";
            echo "🔐 Password: 123456<br>";
        } else {
            echo "❌ Lỗi cập nhật password: " . $stmt->error . "<br>";
        }
    } else {
        echo "<br>✅ Password đã được hash đúng cách<br>";
        
        // Test với một số password phổ biến
        $common_passwords = ['123456', 'password', '123', 'admin', $user['tenkh']];
        echo "<br>🧪 Test với các password phổ biến:<br>";
        
        foreach ($common_passwords as $pwd) {
            if (password_verify($pwd, $user['password'])) {
                echo "✅ Password đúng là: <strong>$pwd</strong><br>";
                break;
            } else {
                echo "❌ Không phải: $pwd<br>";
            }
        }
    }
} else {
    echo "❌ Không tìm thấy user tuninh@gmail.com<br>";
}

echo "<hr>";
echo "<h3>🧪 Form Test Đăng Nhập với User Thật:</h3>";
?>

<form method="post" action="" style="max-width: 300px; margin: 20px 0;">
    <div style="margin-bottom: 10px;">
        <label>Email:</label><br>
        <input type="email" name="email" value="tuninh@gmail.com" style="width: 100%; padding: 5px;">
    </div>
    <div style="margin-bottom: 10px;">
        <label>Password:</label><br>
        <input type="password" name="password" value="123456" style="width: 100%; padding: 5px;">
    </div>
    <button type="submit" name="test_login" style="padding: 10px 20px; background: #28a745; color: white; border: none;">
        Test Đăng Nhập
    </button>
</form>

<?php
if (isset($_POST['test_login'])) {
    echo "<h3>🔐 Kết quả Test Đăng Nhập:</h3>";
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    echo "📧 Email: $email<br>";
    echo "🔑 Password: $password<br>";
    
    $stmt = $conn->prepare("SELECT * FROM khachhang WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if ($user) {
        echo "✅ Tìm thấy user<br>";
        if (password_verify($password, $user['password'])) {
            echo "✅ <strong style='color: green;'>ĐĂNG NHẬP THÀNH CÔNG!</strong><br>";
            
            // Clear admin session
            unset($_SESSION['admin']);
            
            // Set user session
            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['makh'];
            
            echo "✅ Session user đã được set<br>";
            echo "<br>🎉 <a href='/do_dien_tu/index.php' style='color: blue;'>Về trang chủ</a><br>";
        } else {
            echo "❌ Password sai<br>";
        }
    } else {
        echo "❌ Không tìm thấy user<br>";
    }
}

echo "<hr>";
echo "<h3>📊 Session hiện tại:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
?>
