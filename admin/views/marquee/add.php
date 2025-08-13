<div class="container mt-4">
  <h4 class="mb-4">➕ Thêm chữ chạy</h4>
  <form method="POST" class="row g-3 needs-validation" novalidate>
    <div class="col-12">
      <label class="form-label fw-semibold">Nội dung <span class="text-danger">*</span></label>
      <textarea name="noidung" id="marquee-content" class="form-control form-control-lg" rows="2" maxlength="150" required oninput="updateCharCount()"></textarea>
      <div class="d-flex justify-content-between mt-1">
        <div class="form-text">Tối đa 150 ký tự.</div>
        <div class="form-text"><span id="char-count">0</span>/150</div>
      </div>
      <div class="invalid-feedback">Vui lòng nhập nội dung (không quá 150 ký tự).</div>
    </div>
    <div class="col-md-6">
      <label class="form-label fw-semibold">Hiển thị ở <span class="text-danger">*</span></label>
      <select name="vaitro" class="form-select form-select-lg" required>
        <option value="user">👤 Trang người dùng</option>
        <option value="admin">🛠️ Trang quản trị</option>
      </select>
      <div class="invalid-feedback">Vui lòng chọn vị trí hiển thị.</div>
    </div>
    <div class="col-12 d-flex gap-3 mt-4">
      <button type="submit" class="btn btn-success btn-lg d-flex align-items-center gap-2"><span class="bi bi-check-circle"></span> Lưu</button>
      <a href="?page=marquee" class="btn btn-secondary btn-lg d-flex align-items-center gap-2"><span class="bi bi-arrow-left"></span> Quay lại</a>
    </div>
  </form>
</div>
<script>
function updateCharCount() {
  const textarea = document.getElementById('marquee-content');
  document.getElementById('char-count').innerText = textarea.value.length;
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
