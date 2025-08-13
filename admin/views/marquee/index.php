<div class="container mt-4">
  <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
    <h4 class="mb-0">📝 Danh sách dòng chữ chạy</h4>
    <a href="?page=marquee_add" class="btn btn-success btn-lg d-flex align-items-center gap-2" style="font-weight:600;">
      <span class="bi bi-plus-circle"></span> Thêm mới
    </a>
  </div>
  <div class="mb-3 row gx-2 gy-2 align-items-center">
    <div class="col-md-5 col-12">
      <input type="text" id="marquee-search" class="form-control" placeholder="🔍 Tìm kiếm nội dung...">
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle" id="marquee-table">
      <thead class="table-light">
        <tr>
          <th>Nội dung</th>
          <th>Trạng thái</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($marquees)) : ?>
        <tr>
          <td class="fw-semibold"><?= htmlspecialchars($row['noidung']) ?></td>
          <td>
            <?php if($row['trangthai']): ?>
              <span class="badge bg-success">Hiện</span>
            <?php else: ?>
              <span class="badge bg-danger">Ẩn</span>
            <?php endif; ?>
          </td>
          <td>
            <a href="?page=marquee_edit&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm d-inline-flex align-items-center gap-1"><span class="bi bi-pencil-square"></span> Sửa</a>
            <a href="?page=marquee_delete&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm d-inline-flex align-items-center gap-1" onclick="return confirm('Xóa dòng chữ này?')"><span class="bi bi-trash"></span> Xoá</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
// Filter marquee theo nội dung
const marqueeSearch = document.getElementById('marquee-search');
const marqueeTable = document.getElementById('marquee-table');
marqueeSearch.addEventListener('keyup', function() {
  const filter = this.value.toLowerCase();
  for (let row of marqueeTable.tBodies[0].rows) {
    const content = row.cells[0].innerText.toLowerCase();
    row.style.display = content.includes(filter) ? '' : 'none';
  }
});
</script>
