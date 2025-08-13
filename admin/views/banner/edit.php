<?php
include(__DIR__ . '/../../../config/db.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy banner cần sửa
$result = mysqli_query($conn, "SELECT * FROM banner WHERE id = $id");
$banner = mysqli_fetch_assoc($result);

if (!$banner) {
  echo "Không tìm thấy banner.";
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $link = $_POST['link'];
  $status = $_POST['status'];

  // Nếu có chọn ảnh mới
  if (!empty($_FILES['image']['name'])) {
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    // Lưu vào thư mục đúng
    move_uploaded_file($image_tmp, __DIR__ . '/../../../public/uploads/' . $image_name);

    // Cập nhật có ảnh mới
    $sql = "UPDATE banner SET title='$title', link='$link', image_url='$image_name', status='$status' WHERE id = $id";
  } else {
    // Cập nhật không đổi ảnh
    $sql = "UPDATE banner SET title='$title', link='$link', status='$status' WHERE id = $id";
  }

  mysqli_query($conn, $sql);
  header("Location: index.php?page=banner");
  exit;
}
?>

<div class="container mt-4">
  <form method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
    <h4 class="mb-4">✏️ Sửa banner</h4>
    <div class="col-md-6">
      <label class="form-label fw-semibold">Tiêu đề <span class="text-danger">*</span></label>
      <input type="text" name="title" class="form-control form-control-lg" value="<?php echo htmlspecialchars($banner['title']); ?>" required>
      <div class="invalid-feedback">Vui lòng nhập tiêu đề banner.</div>
    </div>
    <div class="col-md-6">
      <label class="form-label fw-semibold">Ảnh hiện tại</label><br>
      <img id="banner-preview" src="../../../public/uploads/<?php echo $banner['image_url']; ?>" style="max-width: 300px; max-height:80px; border-radius:10px; box-shadow:0 2px 8px #ccc;" class="border mb-2">
      <label class="form-label fw-semibold mt-2">Chọn ảnh mới (nếu muốn)</label>
      <input type="file" name="image" class="form-control form-control-lg" accept="image/*" onchange="previewBanner(event)">
      <div class="invalid-feedback">Vui lòng chọn ảnh hợp lệ.</div>
    </div>
    <div class="col-md-6">
      <label class="form-label fw-semibold">Liên kết</label>
      <input type="text" name="link" class="form-control form-control-lg" value="<?php echo htmlspecialchars($banner['link']); ?>">
    </div>
    <div class="col-md-6">
      <label class="form-label fw-semibold">Trạng thái</label>
      <select name="status" class="form-select form-select-lg">
        <option value="active" <?php if ($banner['status'] == 'active') echo 'selected'; ?>>Hiển thị</option>
        <option value="inactive" <?php if ($banner['status'] == 'inactive') echo 'selected'; ?>>Ẩn</option>
      </select>
    </div>
    <div class="col-12 d-flex gap-3 mt-4">
      <button type="submit" class="btn btn-success btn-lg d-flex align-items-center gap-2"><span class="bi bi-save"></span> Lưu</button>
      <a href="index.php?page=banner" class="btn btn-secondary btn-lg d-flex align-items-center gap-2"><span class="bi bi-arrow-left"></span> Huỷ</a>
    </div>
  </form>
</div>

<script>
// Preview ảnh banner khi chọn mới
function previewBanner(event) {
  const [file] = event.target.files;
  if (file) {
    document.getElementById('banner-preview').src = URL.createObjectURL(file);
  }
}
// Bootstrap validate
(() => {
  'use strict';
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>

<?php include(__DIR__ . '/../layout/footer.php'); ?>
