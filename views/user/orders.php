<?php
include __DIR__ . '/../layout/header.php';
require_once __DIR__ . '/../../config/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: /do_dien_tu/index.php?controller=user&action=login');
    exit;
}
$user = $_SESSION['user'];
$makh = intval($user['makh']);

// Lấy danh sách đơn hàng của user
$sql = "SELECT * FROM donhang WHERE makh = $makh ORDER BY ngaydat DESC";
$result = mysqli_query($GLOBALS['conn'], $sql);
$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}
// Xử lý xác nhận đã nhận hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'xac_nhan_nhan_hang') {
    $madon = intval($_POST['madon']);
    // Đảm bảo chỉ chủ đơn hàng mới được xác nhận
    $sql = "UPDATE donhang SET trangthai=4 WHERE madon=$madon AND makh=$makh AND trangthai=3";
    mysqli_query($GLOBALS['conn'], $sql);
    echo '<script>location.href=location.href;</script>';
    exit;
}
// Mapping trạng thái mới
$trangthai_map = [
  0 => ['label' => 'Chờ xác nhận', 'badge' => 'secondary'],
  1 => ['label' => 'Đã duyệt', 'badge' => 'info'],
  2 => ['label' => 'Đang giao', 'badge' => 'primary'],
  3 => ['label' => 'Đã giao', 'badge' => 'success'],
  4 => ['label' => 'Đã nhận', 'badge' => 'success'],
  5 => ['label' => 'Đã hủy', 'badge' => 'danger'],
];
?>
<div class="container mt-4">
  <div class="row">
    <div class="col-md-3 mb-3">
      <div class="list-group shadow-sm rounded-4">
        <a href="/do_dien_tu/views/user/profile.php" class="list-group-item list-group-item-action"><i class="bi bi-person-circle me-2"></i>Thông tin cá nhân</a>
        <a href="/do_dien_tu/views/user/orders.php" class="list-group-item list-group-item-action active"><i class="bi bi-receipt me-2"></i>Đơn hàng</a>
        <a href="/do_dien_tu/views/user/address.php" class="list-group-item list-group-item-action"><i class="bi bi-geo-alt me-2"></i>Địa chỉ</a>
        <a href="/do_dien_tu/views/user/warranty.php" class="list-group-item list-group-item-action"><i class="bi bi-shield-check me-2"></i>Bảo hành</a>
        <a href="/do_dien_tu/index.php?controller=user&action=logout" class="list-group-item list-group-item-action text-danger"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a>
      </div>
    </div>
    <div class="col-md-9">
      <div class="card p-4 shadow-sm rounded-4">
        <h3 class="mb-4"><i class="bi bi-receipt me-2"></i>Đơn hàng của tôi</h3>
        <?php if (empty($orders)): ?>
          <div class="alert alert-info">Bạn chưa có đơn hàng nào.</div>
        <?php else: ?>
        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th>Mã đơn</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th>Tổng tiền</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($orders as $order): ?>
  <tr>
    <td class="fw-bold">#<?php echo $order['madon']; ?></td>
    <td><?php echo $order['ngaydat']; ?></td>
    <td>
      <?php 
        $tt = isset($trangthai_map[$order['trangthai']]) ? $trangthai_map[$order['trangthai']] : $trangthai_map[0]; 
      ?>
      <span class="badge bg-<?= $tt['badge'] ?>">
        <?= $tt['label'] ?>
      </span>
      <?php if ($order['trangthai'] == 3): ?>
        <form method="post" style="display:inline-block">
          <input type="hidden" name="action" value="xac_nhan_nhan_hang">
          <input type="hidden" name="madon" value="<?= $order['madon'] ?>">
          <button class="btn btn-outline-success btn-sm ms-2" onclick="return confirm('Bạn xác nhận đã nhận được hàng?');">Tôi đã nhận hàng</button>
        </form>
      <?php elseif ($order['trangthai'] == 4): ?>
        <div class="mt-2"><em>Đã nhận hàng. [Form đánh giá sản phẩm sẽ hiển thị tại đây]</em></div>
      <?php endif; ?>
    </td>
    <td class="text-danger fw-bold"><?php echo number_format($order['tongtien']); ?> đ</td>
    <td><a href="/do_dien_tu/index.php?controller=order&action=order_detail&madon=<?php echo $order['madon']; ?>" class="btn btn-view-detail btn-sm">Xem chi tiết</a></td>
  </tr>
<?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
