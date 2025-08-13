<?php
session_start();
require_once 'models/KhachHang.php';

echo "<h2>Test Login System</h2>";

// Test database connection
echo "<h3>1. Database Connection Test:</h3>";
try {
    require_once 'config/db.php';
    if ($conn) {
        echo "✅ Database connected successfully<br>";
        
        // Test query
        $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM khachhang");
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            echo "✅ Found " . $row['count'] . " users in database<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
}

// Test login form
if (isset($_POST['test_login'])) {
    echo "<h3>2. Login Test:</h3>";
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    echo "Email: " . htmlspecialchars($email) . "<br>";
    echo "Password length: " . strlen($password) . "<br>";
    
    $user = KhachHang::findByEmail($email);
    if ($user) {
        echo "✅ User found in database<br>";
        echo "User ID: " . $user['makh'] . "<br>";
        echo "User name: " . $user['tenkh'] . "<br>";
        
        if (password_verify($password, $user['password'])) {
            echo "✅ Password verified successfully<br>";
            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['makh'];
            echo "✅ Session set successfully<br>";
        } else {
            echo "❌ Password verification failed<br>";
            echo "Stored hash: " . substr($user['password'], 0, 20) . "...<br>";
        }
    } else {
        echo "❌ User not found with email: " . htmlspecialchars($email) . "<br>";
    }
}

// Test register form
if (isset($_POST['test_register'])) {
    echo "<h3>2. Register Test:</h3>";
    $tenkh = trim($_POST['tenkh']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $diachi = trim($_POST['diachi']);
    $sodienthoai = trim($_POST['sodienthoai']);
    
    echo "Name: " . htmlspecialchars($tenkh) . "<br>";
    echo "Email: " . htmlspecialchars($email) . "<br>";
    echo "Phone: " . htmlspecialchars($sodienthoai) . "<br>";
    echo "Address: " . htmlspecialchars($diachi) . "<br>";
    
    // Check if email exists
    $existing = KhachHang::findByEmail($email);
    if ($existing) {
        echo "❌ Email already exists<br>";
    } else {
        echo "✅ Email is available<br>";
        
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $result = KhachHang::create($tenkh, $email, $hash, $diachi, $sodienthoai);
        
        if ($result) {
            echo "✅ User created successfully<br>";
        } else {
            echo "❌ Failed to create user<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Test Login System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { border: 1px solid #ccc; padding: 20px; margin: 20px 0; }
        input { margin: 5px 0; padding: 8px; width: 200px; }
        button { padding: 10px 20px; margin: 10px 0; }
    </style>
</head>
<body>

<h3>Test Login Form:</h3>
<form method="post">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="test_login">Test Login</button>
</form>

<h3>Test Register Form:</h3>
<form method="post">
    <input type="text" name="tenkh" placeholder="Full Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="text" name="diachi" placeholder="Address" required><br>
    <input type="text" name="sodienthoai" placeholder="Phone" required><br>
    <button type="submit" name="test_register">Test Register</button>
</form>

<?php if (isset($_SESSION['user'])): ?>
<h3>Current Session:</h3>
<p>✅ User logged in: <?php echo $_SESSION['user']['tenkh']; ?></p>
<p>User ID: <?php echo $_SESSION['user_id']; ?></p>
<a href="/do_dien_tu/index.php">Go to Homepage</a>
<?php endif; ?>

</body>
</html>
