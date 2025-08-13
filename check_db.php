<?php
require_once 'config/db.php';

echo "<h2>Database Check</h2>";

// Check connection
if ($conn) {
    echo "✅ Database connected<br><br>";
    
    // Check khachhang table
    echo "<h3>Users in khachhang table:</h3>";
    $result = mysqli_query($conn, "SELECT makh, tenkh, email, trangthai FROM khachhang ORDER BY makh DESC LIMIT 10");
    
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Status</th></tr>";
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['makh'] . "</td>";
            echo "<td>" . htmlspecialchars($row['tenkh']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . $row['trangthai'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "❌ No users found or query failed<br>";
        echo "Error: " . mysqli_error($conn) . "<br>";
    }
    
    // Check table structure
    echo "<h3>Table structure:</h3>";
    $result = mysqli_query($conn, "DESCRIBE khachhang");
    if ($result) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
} else {
    echo "❌ Database connection failed<br>";
}
?>

<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { border-collapse: collapse; margin: 10px 0; }
    th { background-color: #f0f0f0; }
</style>
