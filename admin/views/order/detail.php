<div class="container mt-4">
  <h4>🧾 Chi tiết đơn hàng #<?= $order['madon'] ?></h4>
  <div class="mb-3 p-3 bg-light rounded border">
    <strong>Thông tin người nhận:</strong><br>
    <span class="bi bi-person"></span> <strong><?= htmlspecialchars($order['ten_nguoinhan'] ?? 'Chưa có') ?></strong><br>
    <span class="bi bi-geo-alt"></span> <?= htmlspecialchars($order['diachi_nhan'] ?? 'Chưa có') ?><br>
    <span class="bi bi-telephone"></span> <?= htmlspecialchars($order['sdt_nhan'] ?? 'Chưa có') ?>
  </div>
  <p><strong>Ngày đặt:</strong> <?= $order['ngaydat'] ?> | <strong>Tổng tiền:</strong> <?= number_format($order['tongtien']) ?> ₫</p>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Sản phẩm</th>
        <th>Đơn giá</th>
        <th>Số lượng</th>
        <th>Thành tiền</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($item = mysqli_fetch_assoc($items)) : ?>
        <tr>
          <td><?= $item['tensp'] ?></td>
          <td><?= number_format($item['dongia']) ?> ₫</td>
          <td><?= $item['soluong'] ?></td>
          <td><?= number_format($item['dongia'] * $item['soluong']) ?> ₫</td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <a href="?page=order" class="btn btn-secondary">← Quay lại</a>
</div>
