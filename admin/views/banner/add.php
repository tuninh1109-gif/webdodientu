<?php
// KHÔNG cần session_start nếu đã được gọi ở admin/index.php

// Kết nối CSDL
include(__DIR__ . '/../../../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $link = mysqli_real_escape_string($conn, $_POST['link']);
  $status = mysqli_real_escape_string($conn, $_POST['status']);

  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image_name = time() . '_' . basename($_FILES['image']['name']);
    $image_tmp = $_FILES['image']['tmp_name'];

    $upload_path = __DIR__ . '/../../../public/uploads/' . $image_name;
    move_uploaded_file($image_tmp, $upload_path);

    $sql = "INSERT INTO banner (title, image_url, link, status)
            VALUES ('$title', '$image_name', '$link', '$status')";
    mysqli_query($conn, $sql);

    header("Location: index.php?page=banner");
    exit;
  } else {
    echo "<div class='alert alert-danger'>❌ Vui lòng chọn ảnh hợp lệ!</div>";
  }
}
?>

<div class="container mt-4">
  <h4 class="mb-4">➕ Thêm banner mới</h4>
  <form method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
    <div class="col-md-6">
      <label class="form-label fw-semibold">Tiêu đề <span class="text-danger">*</span></label>
      <input type="text" name="title" class="form-control form-control-lg" required>
      <div class="invalid-feedback">Vui lòng nhập tiêu đề banner.</div>
    </div>
    <div class="col-md-6">
      <label class="form-label fw-semibold">Ảnh banner <span class="text-danger">*</span></label>
      <input type="file" name="image" class="form-control form-control-lg" accept="image/*" required onchange="previewBanner(event)">
      <div class="invalid-feedback">Vui lòng chọn ảnh hợp lệ.</div>
      <div class="mt-2">
        <img id="banner-preview" src="https://placehold.co/300x80?text=Preview" style="max-width: 300px; max-height:80px; border-radius:10px; box-shadow:0 2px 8px #ccc;" class="border mt-2">
      </div>
    </div>
    <div class="col-md-6">
      <label class="form-label fw-semibold">Liên kết</label>
      <input type="text" name="link" class="form-control form-control-lg" placeholder="https://...">
    </div>
    <div class="col-md-6">
      <label class="form-label fw-semibold">Trạng thái</label>
      <select name="status" class="form-select form-select-lg">
        <option value="active">Hiển thị</option>
        <option value="inactive">Ẩn</option>
      </select>
    </div>
    <div class="col-12 d-flex gap-3 mt-4">
      <button type="submit" class="btn btn-success btn-lg d-flex align-items-center gap-2"><span class="bi bi-check-circle"></span> Thêm</button>
      <a href="index.php?page=banner" class="btn btn-secondary btn-lg d-flex align-items-center gap-2"><span class="bi bi-arrow-left"></span> Huỷ</a>
    </div>
  </form>
</div>

<script>
// Preview ảnh banner
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
