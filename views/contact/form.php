<style>
.contact-bg-gradient {
  background: linear-gradient(120deg, #e3f0ff 0%, #ffe600 100%);
  min-height: 100vh;
  padding-top: 40px;
  padding-bottom: 40px;
}
.contact-slogan {
  font-size: 1.25rem;
  font-weight: 600;
  color: #0091ea;
  background: rgba(255,255,255,0.8);
  border-radius: 1.5rem;
  padding: 0.75rem 2rem;
  box-shadow: 0 2px 12px #ffe60022;
  margin-bottom: 2rem;
  display: inline-block;
}
.contact-form-card {
  border: none;
  border-radius: 2rem;
  box-shadow: 0 6px 32px #0091ea22;
  min-height: 100%;
}
.contact-info-card {
  background: linear-gradient(120deg, #ffe600 60%, #0091ea 100%);
  color: #222;
  border: none;
  border-radius: 2rem;
  box-shadow: 0 6px 32px #0091ea22;
  min-height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}
.contact-info-branches {
  display: flex;
  flex-direction: column;
  gap: 1.1rem;
}
.contact-branch-card {
  background: #fffbe7;
  border-radius: 1rem;
  padding: 1rem 1.2rem;
  box-shadow: 0 2px 8px #ffe60033;
  font-size: 1.01rem;
  margin-bottom: 0;
}
.contact-info-card .bi {
  color: #0091ea;
  font-size: 1.25em;
  margin-right: 0.5em;
}
.contact-info-card a {
  color: #0091ea;
  font-weight: 600;
}
.contact-form-card .form-control:focus {
  border-color: #ffe600;
  box-shadow: 0 0 0 0.2rem #ffe60044;
}
.contact-form-card .btn-warning {
  background: linear-gradient(90deg,#ffe600,#fffbe7);
  color: #222;
  border: none;
  font-weight: 700;
  box-shadow: 0 2px 8px #ffe60044;
  transition: 0.2s;
}
.contact-form-card .btn-warning:hover {
  background: #0091ea;
  color: #fff;
}
@media (max-width: 991px) {
  .contact-bg-gradient { padding-top: 20px; padding-bottom: 20px; }
  .contact-slogan { font-size: 1rem; padding: 0.5rem 1.2rem; }
  .contact-info-branches { gap: 0.7rem; }
  .contact-form-card, .contact-info-card { border-radius: 1.2rem; }
}
</style>
<div class="contact-bg-gradient">
  <div class="container animate__animated animate__fadeIn" style="max-width:950px;">
    <div class="text-center mb-4">
      <div class="contact-slogan shadow-sm">
        <i class="bi bi-chat-dots fs-3 me-2 text-warning"></i> HihiMart luôn lắng nghe ý kiến của bạn!
      </div>
    </div>
    <div class="row g-4 align-items-stretch">
      <!-- Form liên hệ -->
      <div class="col-lg-6">
        <div class="card contact-form-card h-100 animate__animated animate__fadeInLeft">
          <div class="card-body p-4">
            <h2 class="mb-3 fw-bold text-primary d-flex align-items-center gap-2">
              <i class="bi bi-envelope-paper fs-2 text-warning"></i> Gửi liên hệ cho HihiMart
            </h2>
            <p class="text-secondary mb-4">Bạn cần tư vấn, góp ý hoặc phản ánh dịch vụ? Hãy để lại thông tin, chúng tôi sẽ liên hệ lại nhanh nhất!</p>
            <?php if (!empty($err)): ?>
              <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                <ul class="mb-0 ps-3">
                  <?php foreach($err as $e): ?><li><?php echo htmlspecialchars($e); ?></li><?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
              </div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
              <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> Gửi liên hệ thành công! Chúng tôi sẽ phản hồi bạn sớm nhất.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
              </div>
            <?php endif; ?>
            <form method="post" action="index.php?controller=contact&action=submit" class="row g-3 animate__animated animate__fadeInLeft">
              <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Họ và tên <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                  <input type="text" name="name" class="form-control rounded-3" required value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                </div>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                  <input type="email" name="email" class="form-control rounded-3" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Số điện thoại</label>
                <div class="input-group">
                  <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                  <input type="text" name="phone" class="form-control rounded-3" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                </div>
              </div>
              <div class="col-12">
                <label class="form-label fw-semibold">Nội dung <span class="text-danger">*</span></label>
                <textarea name="message" rows="4" class="form-control rounded-3" required placeholder="Bạn cần hỗ trợ gì? Hãy mô tả chi tiết..."><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
              </div>
              <div class="col-12 d-grid">
                <button type="submit" class="btn btn-warning btn-lg rounded-pill fw-bold shadow-sm"><i class="bi bi-send"></i> Gửi liên hệ</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- Thông tin liên hệ + bản đồ -->
      <div class="col-lg-6">
        <div class="card contact-info-card h-100 animate__animated animate__fadeInRight">
  <div class="card-body p-4 d-flex flex-column justify-content-between h-100">
    <div class="text-center mb-4">
      <div class="mb-3">
        <i class="bi bi-geo-alt-fill" style="font-size:3rem;color:#0091ea;"></i>
      </div>
      <div class="fw-bold fs-4 mb-2" style="color:#0091ea;">Hệ thống cửa hàng HihiMart</div>
      <div class="mb-2 text-dark fs-5"><i class="bi bi-telephone-fill"></i> <a href="tel:18006601" style="color:#0091ea;font-weight:700;">1800 6601</a></div>
      <div class="mb-3 text-secondary" style="font-size:1.08rem;">Hotline hỗ trợ 8h00 - 21h30 (T2 - CN)</div>
      <div class="mb-3 fw-semibold text-primary">Chúng tôi luôn sẵn sàng phục vụ bạn tại các chi nhánh:</div>
    </div>
    <div class="contact-info-branches mb-3">
      <div class="contact-branch-card" style="font-size:1.09rem;">
        <span class="fw-bold text-primary"><i class="bi bi-shop-window"></i> HihiMart Quận 1</span><br>
        <span><i class="bi bi-geo-alt"></i> 123 Đường ABC, Quận 1, TP.HCM</span><br>
        <span><i class="bi bi-telephone"></i> <a href="tel:18006601">1800 6601</a></span><br>
        <span><i class="bi bi-clock"></i> 8h00 - 21h30 (T2 - CN)</span>
      </div>
      <div class="contact-branch-card" style="font-size:1.09rem;">
        <span class="fw-bold text-primary"><i class="bi bi-shop-window"></i> HihiMart Hà Nội</span><br>
        <span><i class="bi bi-geo-alt"></i> 789 Đường DEF, Q. Cầu Giấy, Hà Nội</span><br>
        <span><i class="bi bi-telephone"></i> <a href="tel:18006601">1800 6601</a></span><br>
        <span><i class="bi bi-clock"></i> 8h00 - 21h30 (T2 - CN)</span>
      </div>
    </div>
    <div class="mb-3 text-center">
      <span class="fw-bold"><i class="bi bi-envelope"></i> Email:</span> <a href="mailto:support@hihimart.vn" style="color:#0091ea;">support@hihimart.vn</a>
    </div>
    <div class="mt-3">
      <div class="rounded-4 overflow-hidden shadow-sm" style="border:2px solid #0091ea33;">
        <iframe src="https://www.google.com/maps?q=10.7769,106.7009&z=15&output=embed" width="100%" height="180" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </div>
</div>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
