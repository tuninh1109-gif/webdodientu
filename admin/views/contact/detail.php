<div class="container py-4" style="max-width:650px;">
  <div class="card shadow border-0 rounded-4">
    <div class="card-body">
      <div class="d-flex align-items-center mb-4 gap-3">
        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
          <i class="bi bi-person-lines-fill fs-2 text-primary"></i>
        </div>
        <div>
          <h4 class="fw-bold mb-0">Chi tiết liên hệ</h4>
          <div class="text-secondary small">Quản lý & xử lý phản hồi khách hàng</div>
        </div>
      </div>
      <div class="row g-3 mb-2">
        <div class="col-12 col-md-6"><strong><i class="bi bi-person-circle text-primary"></i> Họ tên:</strong> <?php echo htmlspecialchars($detail['name']); ?></div>
        <div class="col-12 col-md-6"><strong><i class="bi bi-envelope text-secondary"></i> Email:</strong> <?php echo htmlspecialchars($detail['email']); ?></div>
        <div class="col-12 col-md-6"><strong><i class="bi bi-telephone text-success"></i> Điện thoại:</strong> <?php echo htmlspecialchars($detail['phone']); ?></div>
        <div class="col-12 col-md-6"><strong><i class="bi bi-clock-history text-warning"></i> Ngày gửi:</strong> <?php echo date('d/m/Y H:i', strtotime($detail['created_at'])); ?></div>
        <div class="col-12"><strong><i class="bi bi-chat-dots text-info"></i> Nội dung:</strong>
          <div class="border rounded-3 p-3 bg-light mt-1" style="min-height:80px"><?php echo nl2br(htmlspecialchars($detail['message'])); ?></div>
        </div>
      </div>
      <form method="post" action="index.php?page=contact_update_status" class="row g-3 mt-3">
        <input type="hidden" name="id" value="<?php echo $detail['id']; ?>">
        <div class="col-12 col-md-6">
          <label class="fw-semibold mb-1"><i class="bi bi-flag"></i> Trạng thái:</label>
          <select name="status" class="form-select rounded-pill">
            <option value="pending" <?php if($detail['status']==='pending') echo 'selected'; ?>>Chưa trả lời</option>
            <option value="replied" <?php if($detail['status']==='replied') echo 'selected'; ?>>Đã trả lời</option>
          </select>
        </div>
        <div class="col-12 col-md-6">
          <label class="fw-semibold mb-1"><i class="bi bi-journal-text"></i> Ghi chú xử lý (tuỳ chọn):</label>
          <input type="text" name="note" class="form-control rounded-pill" placeholder="Nhập nội dung ghi chú..." value="<?php echo htmlspecialchars($detail['note'] ?? ''); ?>">
        </div>
        <div class="col-12 d-flex gap-2 mt-2">
          <button type="submit" class="btn btn-success rounded-pill fw-bold px-4"><i class="bi bi-check-circle"></i> Cập nhật</button>
          <a href="index.php?page=contact_admin" class="btn btn-secondary rounded-pill px-4"><i class="bi bi-arrow-left"></i> Quay lại</a>
        </div>
      </form>
      <?php if (!empty($success)): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i> Cập nhật trạng thái thành công!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
        </div>
      <?php endif; ?>
      <hr class="my-4">
      <div class="mb-3">
        <h5 class="fw-bold mb-3"><i class="bi bi-envelope-paper text-primary"></i> Gửi email phản hồi cho khách hàng</h5>
        <?php if (!empty($mail_success)): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> Đã gửi email thành công!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
          </div>
        <?php elseif (!empty($mail_error)): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-x-circle-fill me-2"></i> <?php echo htmlspecialchars($mail_error); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
          </div>
        <?php endif; ?>
        <form method="post" action="index.php?page=contact_send_mail" class="row g-3">
          <input type="hidden" name="id" value="<?php echo $detail['id']; ?>">
          <div class="col-12">
            <label class="form-label fw-semibold">Tiêu đề email <span class="text-danger">*</span></label>
            <input type="text" name="subject" class="form-control rounded-pill" required value="<?php echo htmlspecialchars($_POST['subject'] ?? 'Phản hồi liên hệ HihiMart'); ?>">
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Nội dung email <span class="text-danger">*</span></label>
            <textarea name="body" rows="5" class="form-control rounded-3" required placeholder="Nội dung phản hồi gửi khách..."><?php echo htmlspecialchars($_POST['body'] ?? 'Cảm ơn bạn đã liên hệ HihiMart! Chúng tôi đã nhận được thông tin và sẽ phản hồi sớm nhất.'); ?></textarea>
          </div>
          <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-primary rounded-pill fw-bold px-4"><i class="bi bi-send"></i> Gửi email</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
