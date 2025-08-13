
<div class="container mt-4">
  <?php if (!empty($alert)) echo $alert; ?>
  <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
    <h4 class="mb-0">📦 Danh sách đơn hàng</h4>
    <div class="col-md-4 col-12">
      <input type="text" id="order-search" class="form-control" placeholder="🔍 Tìm kiếm đơn hàng...">
    </div>
  </div>
  <!-- ĐÃ XÓA thông tin HihiMart Admin, liên hệ kỹ thuật, copyright để giao diện gọn gàng hơn -->
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle" id="order-table">
      <thead class="table-light">
        <tr>
          <th>Mã đơn</th>
          <th>Khách đặt</th>
          <th>Người nhận</th>
          <th>Địa chỉ nhận</th>
          <th>SĐT nhận</th>
          <th>Ngày đặt</th>
          <th>Tổng tiền</th>
          <th>Trạng thái</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php 
// Mapping trạng thái số
$trangthai_map = [
  0 => ['label' => 'Chờ xác nhận', 'badge' => 'secondary'],
  1 => ['label' => 'Đã duyệt', 'badge' => 'info'],
  2 => ['label' => 'Đang giao', 'badge' => 'primary'],
  3 => ['label' => 'Đã giao', 'badge' => 'success'],
  4 => ['label' => 'Đã nhận', 'badge' => 'success'],
  5 => ['label' => 'Đã hủy', 'badge' => 'danger'],
];
?>
<?php while ($row = mysqli_fetch_assoc($orders)) : ?>
  <tr>
    <td><?= $row['madon'] ?></td>
    <td><?= $row['tenkh'] ?? ($row['makh'] ?? 'Ẩn') ?></td>
    <td><?= htmlspecialchars($row['ten_nguoinhan'] ?? '') ?></td>
    <td><?= htmlspecialchars($row['diachi_nhan'] ?? '') ?></td>
    <td><?= htmlspecialchars($row['sdt_nhan'] ?? '') ?></td>
    <td><?= $row['ngaydat'] ?></td>
    <td class="text-danger fw-bold"><?= number_format($row['tongtien']) ?> ₫</td>
    <td>
      <?php 
        $status = isset($row['trangthai']) ? intval($row['trangthai']) : 0;
        $statusInfo = $trangthai_map[$status] ?? $trangthai_map[0];
      ?>
      <span class="badge bg-<?= $statusInfo['badge'] ?> text-capitalize"><?= $statusInfo['label'] ?></span>
    </td>
    <td>
      <a href="?page=order_detail&id=<?= $row['madon'] ?>" class="btn btn-info btn-sm d-inline-flex align-items-center gap-1">
        <span class="bi bi-eye"></span> Chi tiết
      </a>
      <?php if ($status === 0): ?>
        <a href="?page=order&duyet=<?= $row['madon'] ?>" class="btn btn-success btn-sm ms-1" onclick="return confirm('Duyệt đơn hàng này?');">
          <span class="bi bi-check2-circle"></span> Duyệt
        </a>
        <a href="?page=order&huydon=<?= $row['madon'] ?>" class="btn btn-danger btn-sm ms-1" onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?');">
          <span class="bi bi-x-circle"></span> Hủy
        </a>
      <?php elseif ($status === 1): ?>
        <a href="?page=order&dang_giao=<?= $row['madon'] ?>" class="btn btn-primary btn-sm ms-1" onclick="return confirm('Chuyển đơn hàng này sang trạng thái Đang giao?');">
          <span class="bi bi-truck"></span> Đang giao
        </a>
      <?php elseif ($status === 2): ?>
        <a href="?page=order&da_giao=<?= $row['madon'] ?>" class="btn btn-success btn-sm ms-1" onclick="return confirm('Xác nhận đã giao đơn hàng này?');">
          <span class="bi bi-box-seam"></span> Đã giao
        </a>
      <?php endif; ?>
    </td>
  </tr>
<?php endwhile; ?>
         

<script>
// Filter đơn hàng theo mã hoặc tên khách
const orderSearch = document.getElementById('order-search');
const orderTable = document.getElementById('order-table');
orderSearch.addEventListener('keyup', function() {
  const filter = this.value.toLowerCase();
  for (let row of orderTable.tBodies[0].rows) {
    const madon = row.cells[0].innerText.toLowerCase();
    const tenkh = row.cells[1].innerText.toLowerCase();
    row.style.display = madon.includes(filter) || tenkh.includes(filter) ? '' : 'none';
  }
});
</script>
