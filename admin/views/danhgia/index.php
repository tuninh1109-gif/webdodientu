
<div class="container mt-4">
  <h4 class="mb-4">📝 Quản lý đánh giá sản phẩm</h4>
  <?php if (!empty($_GET['reply']) && $_GET['reply'] === 'success'): ?>
    <div class="alert alert-success">Đã lưu phản hồi cho khách hàng!</div>
  <?php endif; ?>
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Mã KH</th>
          <th>Mã SP</th>
          <th>Mã đơn</th>
          <th>Điểm</th>
          <th>Nội dung</th>
          <th>Thời gian</th>
          <th>Phản hồi của shop</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reviews as $rv): ?>
          <tr>
            <td><?= $rv['id'] ?></td>
            <td><?= $rv['makh'] ?></td>
            <td><?= $rv['masp'] ?></td>
            <td><?= $rv['madon'] ?></td>
            <td>
  <?php
    $score = intval($rv['diem']);
    for ($i = 1; $i <= 5; $i++) {
      echo $i <= $score
        ? '<i class="bi bi-star-fill text-warning"></i>'
        : '<i class="bi bi-star text-secondary"></i>';
    }
  ?>
  <span class="ms-1 text-muted" style="font-size:12px">(<?= $score ?>/5)</span>
</td>
            <td><?= htmlspecialchars($rv['noidung']) ?></td>
            <td><?= $rv['thoigian'] ?></td>
            <td>
              <form method="post" action="index.php?page=danhgia_reply" class="d-flex flex-column gap-1">
                <input type="hidden" name="id" value="<?= $rv['id'] ?>">
                <textarea name="admin_reply" rows="2" class="form-control" placeholder="Nhập phản hồi cho khách..." style="min-width:180px;max-width:300px;min-height:38px;"><?= htmlspecialchars($rv['admin_reply'] ?? '') ?></textarea>
                <button type="submit" class="btn btn-sm btn-success">Lưu phản hồi</button>
              </form>
            </td>
            <td>
              <!-- Có thể bổ sung nút xóa/sửa nếu cần -->
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>
