<?php
if (session_status() == PHP_SESSION_NONE) session_start();
?>
<link rel="stylesheet" href="/do_dien_tu/public/assets/css/pay-method.css">
<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: /do_dien_tu/index.php?controller=user&action=login&next=' . urlencode($_SERVER['REQUEST_URI']));
    exit();
}
include 'views/layout/header.php';
?>


<div class="container mt-4 pattern-bg" style="border-radius:2.5rem;">
  <div class="main-bg-section" style="margin-top:0;">

  <h3 class="mb-4">Thanh toán & Xác nhận đơn hàng</h3>
  <div class="row">
    <div class="col-lg-7 mb-4">
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <strong>Giỏ hàng của bạn</strong>
        </div>
        <div class="card-body p-0">
          <?php if (!empty($_SESSION['cart'])): ?>
          <table class="table table-hover table-striped mb-0">
            <thead>
              <tr>
                <th>Ảnh</th>
                <th>Sản phẩm</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
              </tr>
            </thead>
            <tbody>
              <?php $tong = 0; foreach ($_SESSION['cart'] as $item): ?>

              <tr class="align-middle">
                <td>
                  <?php
    require_once 'models/Product.php';
    $product = Product::getById($item['masp']);
    if (!empty($product['hinhanh'])):
?>
    <img src="/do_dien_tu/public/assets/images/<?php echo htmlspecialchars($product['hinhanh']); ?>" alt="<?php echo htmlspecialchars($item['tensp']); ?>" style="width:48px;height:auto;border-radius:6px;">
<?php else: ?>
    <span class="text-secondary">Không có ảnh</span>
<?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($item['tensp']); ?></td>
                <td><?php echo number_format($item['dongia']); ?> đ</td>
                <td><span class="badge bg-primary"><?php echo $item['soluong']; ?></span></td>
                <td class="text-danger fw-bold"><?php echo number_format($item['dongia'] * $item['soluong']); ?> đ</td>
              </tr>
              <?php $tong += $item['dongia'] * $item['soluong']; endforeach; ?>
              <tr class="table-info">
                <td colspan="4" class="text-end"><strong>Tổng cộng:</strong></td>
                <td class="fw-bold text-success"><?php echo number_format($tong); ?> đ</td>
              </tr>
            </tbody>
          </table>
          <?php else: ?>
            <div class="alert alert-info m-3">Giỏ hàng của bạn đang trống.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
          <strong>Thông tin khách hàng</strong>
        </div>
        <div class="card-body">
          <?php
          // Lấy danh sách địa chỉ nhận hàng nếu đã đăng nhập
          $diachis = [];
          if (isset($_SESSION['user']['makh'])) {
              $makh = intval($_SESSION['user']['makh']);
              $rs = mysqli_query($GLOBALS['conn'], "SELECT * FROM diachi_nhanhang WHERE makh = $makh ORDER BY mac_dinh DESC, id DESC");
              while ($row = mysqli_fetch_assoc($rs)) $diachis[] = $row;
          }
          ?>
          <form method="POST">
            <?php if (!empty($diachis)): ?>
            <div class="mb-3">
              <label class="form-label">Chọn địa chỉ nhận hàng đã lưu</label>
              <select class="form-select" name="diachi_saved" onchange="fillAddress(this)">
                <option value="">-- Nhập địa chỉ mới --</option>
                <?php foreach ($diachis as $dc): ?>
                  <option value="<?php echo $dc['id']; ?>"
                    data-ten="<?php echo htmlspecialchars($dc['ten_nguoinhan']); ?>"
                    data-diachi="<?php echo htmlspecialchars($dc['diachi']); ?>"
                    data-sdt="<?php echo htmlspecialchars($dc['sodienthoai']); ?>"
                  ><?php echo htmlspecialchars($dc['ten_nguoinhan'] . ' - ' . $dc['diachi'] . ' - ' . $dc['sodienthoai']); ?><?php if ($dc['mac_dinh']) echo ' (Mặc định)'; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <?php endif; ?>
            <div class="mb-3">
              <label class="form-label">Họ tên người nhận</label>
              <input type="text" name="tenkh" id="tenkh" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Địa chỉ nhận hàng</label>
              <input type="text" name="diachi" id="diachi" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Số điện thoại người nhận</label>
              <input type="text" name="sodienthoai" id="sodienthoai" class="form-control" required>
            </div>
            <?php if (!empty($diachis)): ?>
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" name="luu_diachi" id="luu_diachi">
              <label class="form-check-label" for="luu_diachi">Lưu địa chỉ này cho lần sau</label>
            </div>
            <?php endif; ?>
            <script>
            function fillAddress(sel) {
              var opt = sel.options[sel.selectedIndex];
              document.getElementById('tenkh').value = opt.getAttribute('data-ten') || '';
              document.getElementById('diachi').value = opt.getAttribute('data-diachi') || '';
              document.getElementById('sodienthoai').value = opt.getAttribute('data-sdt') || '';
            }
            </script>
            <div class="mb-3">
              <label class="form-label">Ghi chú</label>
              <textarea name="ghichu" class="form-control" rows="2"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Phương thức thanh toán</label>
              <div class="row g-3">
                <div class="col-12 col-md-6">
                  <label class="pay-method-card w-100">
                    <input type="radio" name="thanhtoan" value="cod" checked hidden>
                    <div class="pay-method-content">
                      <img src="/do_dien_tu/public/assets/images/cod-icon.png" alt="COD" class="pay-method-icon">
                      <span>Thanh toán khi nhận hàng (COD)</span>
                    </div>
                  </label>
                </div>
                <div class="col-12 col-md-6">
                  <label class="pay-method-card w-100">
                    <input type="radio" name="thanhtoan" value="bank" hidden>
                    <div class="pay-method-content">
                      <img src="/do_dien_tu/public/assets/images/bank-icon.png" alt="Bank" class="pay-method-icon">
                      <span>Chuyển khoản ngân hàng</span>
                    </div>
                  </label>
                </div>
              </div>
            </div>
            <div id="bank-info" style="display:none; border: 1px solid #e3f0ff; border-radius:10px; padding: 16px; background: #f8fbff;">
              <div class="mt-3">
                <div class="fw-bold mb-1">Quét mã QR để chuyển khoản nhanh:</div>
                <img src="/do_dien_tu/public/assets/images/bank-qr.png" alt="QR chuyển khoản ngân hàng" style="max-width:160px; border-radius:10px; border:1.5px solid #90caf9; background:#fff; padding:4px;">
              </div>
            </div>
            <script>
            document.querySelectorAll('input[name="thanhtoan"]').forEach(function(el) {
              el.addEventListener('change', function() {
                document.getElementById('bank-info').style.display = this.value === 'bank' ? 'block' : 'none';
              });
            });
            </script>
            <button type="submit" class="btn btn-success w-100 py-2 fw-bold">Xác nhận đặt hàng</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

  </div>
<?php include 'views/layout/footer.php'; ?>
