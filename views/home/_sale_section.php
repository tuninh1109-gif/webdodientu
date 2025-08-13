<?php
// Tối ưu section sale: lấy 1 chương trình sale đang chạy, lấy end_time chung cho banner và sản phẩm
include_once __DIR__ . '/../../config/db.php';
$saleEvent = null;
$products_sale = [];

// Lấy chương trình sale đang chạy
$rsSale = mysqli_query($conn, "SELECT * FROM sales WHERE status=1 AND start_time <= NOW() AND end_time >= NOW() ORDER BY end_time ASC LIMIT 1");
if ($rsSale && $saleEvent = mysqli_fetch_assoc($rsSale)) {
    $sale_id = $saleEvent['id'];
    // Lấy danh sách sản phẩm sale (có thêm p.masp để tránh lỗi undefined)
    $rsProducts = mysqli_query($conn, "
        SELECT sp.*, p.masp, p.tensp, p.hinhanh, p.dongia
        FROM sale_products sp
        JOIN sanpham p ON p.masp = sp.product_id
        WHERE sp.sale_id = $sale_id AND sp.quantity > 0
        ORDER BY sp.id ASC
    ");
    while ($row = mysqli_fetch_assoc($rsProducts)) {
        $products_sale[] = $row;
    }
}
?>
<?php if ($saleEvent && count($products_sale)): ?>
<div class="sale-banner-main my-4 p-3" style="background: linear-gradient(90deg, #ff9800 60%, #fffde7 100%); border-radius: 1.5rem; box-shadow: 0 4px 24px #ff980033;">
  <div class="d-flex align-items-center justify-content-between flex-wrap">
    <div class="d-flex align-items-center gap-3">
      <img src="/do_dien_tu/public/assets/images/sale-flash.png" style="height:60px">
      <div>
        <div class="fs-2 fw-bold text-danger">GIỜ VÀNG GIÁ SỐC</div>
        <div class="fs-5 fw-semibold text-dark">Săn sale thần tốc - Chỉ hôm nay!</div>
      </div>
    </div>
    <div class="countdown-box text-center">
      <span class="fs-4 fw-bold sale-countdown" data-end="<?= date('c', strtotime($saleEvent['end_time'])) ?>">00:00:00</span>
      <div class="small text-muted">Kết thúc sau</div>
    </div>
  </div>
</div>

<div class="row row-cols-2 row-cols-md-5 g-3 mb-4">
<?php foreach ($products_sale as $sp): 
  $discount = 0;
  if ($sp['dongia'] > 0 && $sp['sale_price'] > 0) {
    $discount = round(100 - ($sp['sale_price']/$sp['dongia'])*100);
  }
?>
  <div class="col-12 col-sm-6 col-md-4 col-lg-3">
    <div class="card h-100 border-0 shadow sale-card position-relative">
      <div class="sale-badge position-absolute top-0 start-0 bg-danger text-white px-3 py-1 rounded-bottom-end fw-bold" style="z-index:2;font-size:1rem;">-<?= $discount ?>%</div>
      <div class="sale-img-wrap bg-light d-flex align-items-center justify-content-center" style="height:180px;overflow:hidden;border-radius:12px 12px 0 0;">
        <img src="/do_dien_tu/public/assets/images/<?php echo htmlspecialchars($sp['hinhanh']); ?>" alt="<?php echo htmlspecialchars($sp['tensp']); ?>" class="img-fluid" style="max-height:160px;object-fit:contain;">
      </div>
      <div class="card-body p-3 d-flex flex-column">
        <div class="mb-1 text-truncate fw-bold" title="<?= htmlspecialchars($sp['tensp']) ?>" style="font-size:1.08rem;min-height:36px;">
          <?= htmlspecialchars($sp['tensp']) ?>
        </div>
        <div class="mb-2">
          <span class="text-danger fw-bold fs-5"><?= number_format($sp['sale_price']) ?> đ</span>
          <span class="text-muted text-decoration-line-through ms-2 small"><?= number_format($sp['dongia']) ?> đ</span>
        </div>
        <div class="d-flex align-items-center mb-2">
          <span class="badge bg-warning text-dark me-2" style="font-size:0.95em;">Còn lại: <?= (int)$sp['quantity'] ?></span>
          <span class="small text-muted">
            Kết thúc sau: <span class="sale-countdown" data-end="<?= date('c', strtotime($saleEvent['end_time'])) ?>">00:00:00</span>
          </span>
        </div>
        <a href="index.php?controller=product&action=detail&id=<?= htmlspecialchars($sp['masp']) ?>"
           class="btn btn-danger btn-sm fw-bold mt-auto w-100 shadow-sm rounded-pill"
           style="background-color:rgb(53, 220, 67); border-color: #dc3545; transition: all 0.3s ease;"
           onmouseover="this.style.backgroundColor='#c82333'; this.style.borderColor='#bd2130';"
           onmouseout="this.style.backgroundColor='#dc3545'; this.style.borderColor='#dc3545';">
           Mua ngay
        </a>
      </div>
    </div>
  </div>
<?php endforeach; else: ?>
  <div class="col-12 text-center text-muted">Hiện chưa có sản phẩm sale.</div>
<?php endif; ?>
</div>

<script>
function updateAllCountdowns() {
  document.querySelectorAll('.sale-countdown').forEach(function(el) {
    if (!el) return;
    var end = new Date(el.getAttribute('data-end')).getTime();
    if (isNaN(end)) return; // bảo vệ nếu format sai
    var now = new Date().getTime();
    var distance = end - now;
    if (distance < 0) distance = 0;
    var h = Math.floor((distance / (1000 * 60 * 60)));
    var m = Math.floor((distance / (1000 * 60)) % 60);
    var s = Math.floor((distance / 1000) % 60);
    el.textContent = (h<10?'0':'')+h+':' + (m<10?'0':'')+m+':' + (s<10?'0':'')+s;

    // Disable nút mua nếu hết giờ
    if (distance <= 0) {
      let card = el.closest('.sale-card');
      if (card) {
        let btn = card.querySelector('.btn-danger');
        if (btn) {
          btn.disabled = true;
          btn.textContent = 'Đã hết giờ';
          btn.classList.add('btn-secondary');
          btn.classList.remove('btn-danger');
        }
      }
    }
  });
}
setInterval(updateAllCountdowns, 1000);
updateAllCountdowns();
</script>
