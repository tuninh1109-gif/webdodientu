<?php
// Kết nối CSDL
include(__DIR__ . '/../../../config/db.php');

// Xử lý lọc sản phẩm
$where = [];
if (!empty($_GET['maloai'])) {
  $where[] = 'sanpham.maloai = ' . (int)$_GET['maloai'];
}
if (!empty($_GET['math'])) {
  $where[] = 'sanpham.math = ' . (int)$_GET['math'];
}
if (!empty($_GET['trangthai']) && in_array($_GET['trangthai'], ['0', '1'])) {
  $where[] = 'sanpham.trangthai = ' . (int)$_GET['trangthai'];
}
if (!empty($_GET['q'])) {
  $q = mysqli_real_escape_string($conn, $_GET['q']);
  $where[] = "(sanpham.tensp LIKE '%$q%' OR sanpham.mota LIKE '%$q%')";
}
$where_sql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

// Phân trang
$limit = 10;
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Truy vấn sản phẩm (có phân trang)
$sql = "SELECT sanpham.*, loaisp.tenloai, thuonghieu.tenthuonghieu
        FROM sanpham 
        JOIN loaisp ON sanpham.maloai = loaisp.maloai
        LEFT JOIN thuonghieu ON sanpham.math = thuonghieu.math
        $where_sql
        ORDER BY sanpham.masp DESC
        LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

// Tổng sản phẩm (phục vụ phân trang)
$sql_count = "SELECT COUNT(*) as total FROM sanpham 
              JOIN loaisp ON sanpham.maloai = loaisp.maloai
              LEFT JOIN thuonghieu ON sanpham.math = thuonghieu.math
              $where_sql";
$count_rs = mysqli_query($conn, $sql_count);
$total = mysqli_fetch_assoc($count_rs)['total'] ?? 0;
$total_pages = ceil($total / $limit);
?>

<div class="container mt-3">
  <?php
  // Hiển thị thông báo
  if (isset($_GET['msg'])) {
    switch ($_GET['msg']) {
      case 'delete_success':
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> Xóa sản phẩm thành công!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
        break;
      case 'delete_error':
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> Có lỗi xảy ra khi xóa sản phẩm!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
        break;
      case 'not_found':
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> Không tìm thấy sản phẩm cần xóa!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
        break;
      case 'invalid_id':
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> ID sản phẩm không hợp lệ!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
        break;
    }
  }
  ?>
  
  <div class="d-flex flex-wrap align-items-center justify-content-between mb-3 gap-2">
    <h3 class="mb-0">📦 Danh sách sản phẩm</h3>
    <a href="?page=product_add" class="btn btn-success btn-lg d-flex align-items-center gap-2" style="font-weight:600;">
      <span class="bi bi-plus-circle"></span> Thêm sản phẩm
    </a>
  </div>

  <form class="mb-3 d-flex flex-wrap align-items-center justify-content-center gap-3 bg-light rounded shadow-sm py-3 px-3" method="get" autocomplete="off" style="--bs-bg-opacity:.97;max-width:900px;margin:auto;">
    <input type="hidden" name="page" value="product">
    <div style="flex:1 1 180px;min-width:180px;max-width:220px;">
      <div class="input-group">
        <span class="input-group-text bg-white"><i class="bi bi-layers"></i></span>
        <select name="maloai" id="maloai-select" class="form-select">
          <option value="">-- Chọn loại sản phẩm --</option>
          <?php 
          $loaisp_rs = mysqli_query($conn, "SELECT * FROM loaisp WHERE trangthai=1");
          $selected_maloai = isset($_GET['maloai']) ? (int)$_GET['maloai'] : '';
          while ($loai = mysqli_fetch_assoc($loaisp_rs)): ?>
            <option value="<?php echo $loai['maloai']; ?>" <?php if($selected_maloai==$loai['maloai']) echo 'selected'; ?>>
              <?php echo htmlspecialchars($loai['tenloai']); ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
    </div>
    <div style="flex:1 1 180px;min-width:180px;max-width:220px;">
      <div class="input-group">
        <span class="input-group-text bg-white"><i class="bi bi-award"></i></span>
        <select name="math" id="brand-select" class="form-select">
          <option value="">-- Chọn thương hiệu --</option>
        </select>
      </div>
    </div>
    <div style="flex:1 1 160px;min-width:150px;max-width:180px;">
      <div class="input-group">
        <span class="input-group-text bg-white"><i class="bi bi-toggle-on"></i></span>
        <select name="trangthai" class="form-select">
          <option value="">-- Trạng thái --</option>
          <option value="1" <?php if(isset($_GET['trangthai']) && $_GET['trangthai']==='1') echo 'selected'; ?>>Hoạt động</option>
          <option value="0" <?php if(isset($_GET['trangthai']) && $_GET['trangthai']==='0') echo 'selected'; ?>>Ngừng</option>
        </select>
      </div>
    </div>
    <div style="flex:2 1 220px;min-width:220px;max-width:320px;">
      <div class="input-group">
        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
        <input type="text" id="product-search" name="q" class="form-control" placeholder="Tìm kiếm tên, mô tả..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
      </div>
    </div>
    <div style="flex:0 1 90px;min-width:90px;max-width:120px;">
      <button type="submit" class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-1"><span class="bi bi-funnel"></span> Lọc</button>
    </div>
    <div style="flex:0 1 110px;min-width:100px;max-width:130px;">
      <a href="?page=product" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-1"><span class="bi bi-x-circle"></span> Xóa lọc</a>
    </div>
  </form>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const maloaiSelect = document.getElementById('maloai-select');
      const brandSelect = document.getElementById('brand-select');
      function loadBrands(maloai, selectedMath) {
        brandSelect.innerHTML = '<option value="">-- Chọn thương hiệu --</option>';
        if (!maloai) return;
        fetch('views/product/_brand_select.php?maloai=' + maloai + (selectedMath ? ('&selected=' + selectedMath) : ''))
          .then(res => res.text())
          .then(html => {
            brandSelect.innerHTML = html;
          });
      }
      maloaiSelect.addEventListener('change', function() {
        loadBrands(this.value, null);
      });
      <?php if (!empty($_GET['maloai'])): ?>
        loadBrands(<?php echo (int)$_GET['maloai']; ?>, <?php echo isset($_GET['math']) ? (int)$_GET['math'] : 'null'; ?>);
      <?php endif; ?>
    });
  </script>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle" id="product-table">
      <thead class="table-light">
        <tr>
          <th>Ảnh</th>
          <th>Tên SP</th>
          <th>Giá</th>
          <th>Số lượng</th>
          <th>Loại</th>
          <th>Thương hiệu</th>
          <th>Nổi bật</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $empty_result = true;
        while ($row = mysqli_fetch_assoc($result)):
          $empty_result = false;
        ?>
        <tr>
          <td>
            <?php
            $img_file = $row['hinhanh'] ?? '';
            $img_path = $img_file ? "/do_dien_tu/public/assets/images/{$img_file}" : "/do_dien_tu/public/assets/images/no-image.png";
            ?>
            <img src="<?php echo $img_path; ?>" width="64" height="64" class="rounded shadow-sm border" style="object-fit:cover;" onerror="this.onerror=null;this.src='/do_dien_tu/public/assets/images/no-image.png';">
          </td>
          <td class="fw-semibold"><?php echo htmlspecialchars($row['tensp']); ?></td>
          <td class="text-danger fw-bold"><?php echo number_format($row['dongia']); ?> đ</td>
          <td class="text-center fw-bold"><?php echo (int)$row['soluong']; ?></td>
          <td><span class="badge bg-primary bg-opacity-75"><?php echo htmlspecialchars($row['tenloai']); ?></span></td>
          <td>
            <?php if (!empty($row['tenthuonghieu'])): ?>
              <span class="badge bg-info bg-opacity-75"><?php echo htmlspecialchars($row['tenthuonghieu']); ?></span>
            <?php else: ?>
              <span class="text-muted">Không xác định</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if (!empty($row['hot'])): ?>
              <span class="badge bg-warning text-dark">HOT</span>
            <?php endif; ?>
          </td>
          <td>
            <a href="?page=product_edit&id=<?php echo $row['masp']; ?>" class="btn btn-warning btn-sm d-inline-flex align-items-center gap-1">
              <span class="bi bi-pencil-square"></span> Sửa
            </a>
            <a href="?page=product_delete&id=<?php echo $row['masp']; ?>" class="btn btn-danger btn-sm d-inline-flex align-items-center gap-1" onclick="return confirm('Xoá sản phẩm này?')">
              <span class="bi bi-trash"></span> Xoá
            </a>
          </td>
        </tr>
        <?php endwhile; ?>

        <?php if ($empty_result): ?>
        <tr>
          <td colspan="8" class="text-center text-muted py-4">
            <i class="bi bi-emoji-frown" style="font-size:2rem;"></i><br>
            Không tìm thấy sản phẩm phù hợp.<br>
            <span class="small">Thử thay đổi bộ lọc hoặc <a href="?page=product" class="text-primary">xóa bộ lọc</a>.</span>
          </td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php if ($total_pages > 1): ?>
  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center my-3">
      <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
          <a class="page-link" href="?<?php
            $query = $_GET;
            $query['p'] = $i;
            echo http_build_query($query);
          ?>">Trang <?php echo $i; ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
  <?php endif; ?>
</div>

<script>
const searchInput = document.getElementById('product-search');
const table = document.getElementById('product-table');
searchInput.addEventListener('keyup', function() {
  const filter = this.value.toLowerCase();
  for (let row of table.tBodies[0].rows) {
    const name = row.cells[1].innerText.toLowerCase();
    row.style.display = name.includes(filter) ? '' : 'none';
  }
});
</script>

<?php include(__DIR__ . '/../layout/footer.php'); ?>
