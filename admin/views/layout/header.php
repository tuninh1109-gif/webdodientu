<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quản trị Admin - HihiMart</title>
  <!-- Google Fonts: Montserrat, Roboto -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../public/assets/css/admin.css">
  <!-- Chart.js CDN for dashboard charts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<?php
include __DIR__ . '/../../../config/db.php';
$query = "SELECT * FROM marquee WHERE trangthai = 1 AND vaitro = 'admin' ORDER BY id DESC LIMIT 1";
$marquees = mysqli_query($conn, $query);
if ($row = mysqli_fetch_assoc($marquees)) {
  echo '<div class="bg-warning text-dark py-1 text-center fw-bold">';
  echo '<marquee behavior="scroll" direction="left">' . htmlspecialchars($row['noidung']) . '</marquee>';
  echo '</div>';
}
