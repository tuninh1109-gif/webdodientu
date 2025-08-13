<div class="container py-4">
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <h3 class="fw-bold mb-0"><i class="bi bi-inbox"></i> Quản lý liên hệ
      <?php if (isset($new_count) && $new_count > 0): ?>
        <span class="badge bg-danger ms-2" style="font-size:.95em;"><i class="bi bi-bell-fill"></i> <?php echo $new_count; ?> mới</span>
      <?php endif; ?>
    </h3>
    <form class="d-flex gap-2" method="get" style="min-width:300px;">
      <input type="hidden" name="page" value="contact_admin">
      <input type="text" name="q" class="form-control form-control-sm rounded-pill" placeholder="Tìm tên, email, SĐT..." value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
      <select name="status" class="form-select form-select-sm rounded-pill">
        <option value="">Tất cả</option>
        <option value="pending" <?php if(($_GET['status']??'')==='pending') echo 'selected'; ?>>Chưa trả lời</option>
        <option value="replied" <?php if(($_GET['status']??'')==='replied') echo 'selected'; ?>>Đã trả lời</option>
      </select>
      <button class="btn btn-primary btn-sm rounded-pill" type="submit"><i class="bi bi-search"></i></button>
    </form>
  </div>
  <div class="card shadow border-0 rounded-4">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table align-middle mb-0 table-hover">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Họ tên</th>
              <th>Email</th>
              <th>Điện thoại</th>
              <th>Ngày gửi</th>
              <th>Trạng thái</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
          <?php $i=1; while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td class="fw-semibold"><i class="bi bi-person-circle text-primary"></i> <?php echo htmlspecialchars($row['name']); ?></td>
              <td><i class="bi bi-envelope text-secondary"></i> <?php echo htmlspecialchars($row['email']); ?></td>
              <td><i class="bi bi-telephone text-success"></i> <?php echo htmlspecialchars($row['phone']); ?></td>
              <td><i class="bi bi-clock-history text-warning"></i> <?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
              <td>
                <?php if ($row['status']==='pending'): ?>
                  <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split"></i> Chưa trả lời</span>
                <?php else: ?>
                  <span class="badge bg-success"><i class="bi bi-check2-circle"></i> Đã trả lời</span>
                <?php endif; ?>
              </td>
              <td>
                <a href="index.php?page=contact_detail&id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm rounded-pill"><i class="bi bi-eye"></i> Xem</a>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
