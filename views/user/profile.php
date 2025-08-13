<?php
include __DIR__ . '/../layout/header.php';
?>
<head>
  <link rel="stylesheet" href="/do_dien_tu/public/assets/css/main.css">
</head>
<?php
if (empty($_SESSION['user'])) {
    echo '<div class="container mt-4"><p>Bạn cần đăng nhập để xem thông tin cá nhân.</p></div>';
    include __DIR__ . '/../layout/footer.php';
    exit;
}
$user = $_SESSION['user'];
?>
<div class="container mt-4">
  <div class="row">
    <div class="col-md-3 mb-3">
      <div class="list-group shadow-sm rounded-4">
        <a href="/do_dien_tu/views/user/profile.php" class="list-group-item list-group-item-action active"><i class="bi bi-person-circle me-2"></i>Thông tin cá nhân</a>
        <a href="/do_dien_tu/index.php?controller=user&action=orders" class="list-group-item list-group-item-action"><i class="bi bi-receipt me-2"></i>Đơn hàng</a>
        <a href="/do_dien_tu/views/user/address.php" class="list-group-item list-group-item-action"><i class="bi bi-geo-alt me-2"></i>Địa chỉ</a>
        <a href="/do_dien_tu/views/user/warranty.php" class="list-group-item list-group-item-action"><i class="bi bi-shield-check me-2"></i>Bảo hành</a>
        <a href="/do_dien_tu/index.php?controller=user&action=logout" class="list-group-item list-group-item-action text-danger"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a>
      </div>
    </div>
    <div class="col-md-9">
      <div class="card p-4 shadow-sm rounded-4">
        <h3 class="mb-4"><i class="bi bi-person-circle me-2"></i>Thông tin cá nhân</h3>
        <p><strong>Họ tên:</strong> <?php echo htmlspecialchars($user['tenkh']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Số điện thoại:</strong> <?php echo htmlspecialchars($user['sodienthoai']); ?></p>
        <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($user['diachi']); ?></p>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
