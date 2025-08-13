<?php
// Không cần session_start vì đã có ở admin/index.php

// Dùng đường dẫn tuyệt đối tránh lỗi include sai
include(__DIR__ . '/../../../config/db.php');


// Truy vấn banner
$result = mysqli_query($conn, "SELECT * FROM banner");
?>

<div class="container mt-4">
  <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
    <h4 class="mb-0">🖼 Quản lý Banner</h4>
    <a href="index.php?page=banner_add" class="btn btn-success btn-lg d-flex align-items-center gap-2" style="font-weight:600;">
      <span class="bi bi-plus-circle"></span> Thêm banner
    </a>
  </div>

  <div class="mb-3 row gx-2 gy-2 align-items-center">
    <div class="col-md-4 col-12">
      <input type="text" id="banner-search" class="form-control" placeholder="🔍 Tìm kiếm banner theo tiêu đề...">
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle" id="banner-table">
      <thead class="table-light">
        <tr>
          <th>Ảnh</th>
          <th>Tiêu đề</th>
          <th>Liên kết</th>
          <th>Trạng thái</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td>
              <img src="/do_dien_tu/public/uploads/<?php echo $row['image_url']; ?>" width="90" height="48" class="rounded shadow-sm border" style="object-fit:cover;">
            </td>
            <td class="fw-semibold"><?php echo htmlspecialchars($row['title']); ?></td>
            <td><a href="<?php echo htmlspecialchars($row['link']); ?>" target="_blank" class="text-primary text-decoration-underline"><?php echo htmlspecialchars($row['link']); ?></a></td>
            <td>
              <?php if($row['status'] === 'active'): ?>
                <span class="badge bg-success">Hiển thị</span>
              <?php else: ?>
                <span class="badge bg-danger">Ẩn</span>
              <?php endif; ?>
            </td>
            <td>
              <a href="index.php?page=banner_edit&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm d-inline-flex align-items-center gap-1">
                <span class="bi bi-pencil-square"></span> Sửa
              </a>
              <button class="btn btn-danger btn-sm d-inline-flex align-items-center gap-1 btn-delete-banner" data-id="<?php echo $row['id']; ?>" data-title="<?php echo htmlspecialchars($row['title']); ?>">
  <span class="bi bi-trash"></span> Xoá
</button>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
// Filter banner theo tiêu đề
const bannerSearch = document.getElementById('banner-search');
const bannerTable = document.getElementById('banner-table');
bannerSearch.addEventListener('keyup', function() {
  const filter = this.value.toLowerCase();
  for (let row of bannerTable.tBodies[0].rows) {
    const title = row.cells[1].innerText.toLowerCase();
    row.style.display = title.includes(filter) ? '' : 'none';
  }
});
</script>

<?php include(__DIR__ . '/../layout/footer.php'); ?>
