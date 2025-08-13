<?php
include(__DIR__ . '/../../../config/db.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$result = mysqli_query($conn, "SELECT image_url FROM banner WHERE id = $id");
$banner = mysqli_fetch_assoc($result);

if ($banner) {
  // Đường dẫn tới ảnh thật sự
  $file_path = __DIR__ . '/../../../public/uploads/' . $banner['image_url'];
  
  if (file_exists($file_path)) {
    unlink($file_path); // Xoá ảnh
  }

  // Xoá bản ghi
  mysqli_query($conn, "DELETE FROM banner WHERE id = $id");
}

header("Location: index.php");
exit;
