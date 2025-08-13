<?php // Trang quản lý footer chuyên nghiệp AJAX, tab, CKEditor, SweetAlert2 không reload ?>
<div class="container mt-4">
  <div class="row">
    <div class="col-lg-7">
      <h3 class="mb-3">Quản lý Footer</h3>
      <ul class="nav nav-tabs mb-3" id="footerTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="tab-user" data-type="user" type="button" role="tab">Footer User</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="tab-admin" data-type="admin" type="button" role="tab">Footer Admin</button>
        </li>
      </ul>
      <form id="footerForm" autocomplete="off">
        <div class="mb-3">
          <label for="footer-content" class="form-label fw-semibold">Nội dung footer (HTML hoặc text):</label>
          <textarea name="content" id="footer-content" class="form-control" rows="7" placeholder="Nhập nội dung HTML hoặc text cho footer..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary px-4">Lưu</button>
      </form>
    </div>
    <div class="col-lg-5">
      <div class="card shadow-sm mt-4 mt-lg-0">
        <div class="card-header bg-light fw-bold"><i class="bi bi-eye"></i> Xem trước footer</div>
        <div class="card-body" id="footer-preview" style="min-height:120px; background:#f9f9f9;"></div>
      </div>
    </div>
  </div>
</div>
<!-- CKEditor & SweetAlert2 CDN -->
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let currentType = 'user';
let editor;

function loadFooter(type) {
  fetch('/do_dien_tu/admin/views/footer/api.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: `action=get&type=${type}`
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      editor.setData(data.content || '');
      document.getElementById('footer-preview').innerHTML = data.content || '<span class="text-muted fst-italic">Chưa có nội dung footer...</span>';
    }
  });
}

window.addEventListener('DOMContentLoaded', function() {
  editor = CKEDITOR.replace('footer-content');
  editor.on('change', function() {
    document.getElementById('footer-preview').innerHTML = editor.getData();
  });
  // Tab switch
  document.getElementById('tab-user').onclick = function() {
    currentType = 'user';
    this.classList.add('active');
    document.getElementById('tab-admin').classList.remove('active');
    loadFooter('user');
  };
  document.getElementById('tab-admin').onclick = function() {
    currentType = 'admin';
    this.classList.add('active');
    document.getElementById('tab-user').classList.remove('active');
    loadFooter('admin');
  };
  // Form submit
  document.getElementById('footerForm').onsubmit = function(e) {
    e.preventDefault();
    const content = editor.getData();
    fetch('/do_dien_tu/admin/views/footer/api.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: `action=save&type=${currentType}&content=${encodeURIComponent(content)}`
    })
    .then(res => res.json())
    .then(data => {
      Swal.fire({
        toast: true,
        position: 'top-end',
        icon: data.success ? 'success' : 'error',
        title: data.message,
        showConfirmButton: false,
        timer: 2200,
        timerProgressBar: true
      });
      if (data.success) {
        document.getElementById('footer-preview').innerHTML = content;
      }
    });
  };
  // Load default (user)
  loadFooter('user');
});
</script>
<style>
#footerTab .nav-link { cursor:pointer; font-weight:600; }
#footerTab .nav-link.active {
  background: #0d6efd; color: #fff;
}
</style>
