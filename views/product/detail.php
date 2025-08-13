<?php include 'views/layout/header.php'; ?>

<div class="container mt-4 pattern-bg" style="border-radius:2.5rem;">
  <div class="main-bg-section" style="margin-top:0;">

<style>
  .product-img-big {
    border-radius: 18px;
    border: 2px solid #f0f0f0;
    box-shadow: 0 2px 16px rgba(33,150,243,0.08);
    transition: transform 0.2s;
    background: #fff;
  }
  .product-img-big:hover { transform: scale(1.04); box-shadow: 0 4px 32px rgba(33,150,243,0.13); }
  .product-info-card {
    border-radius: 18px;
    box-shadow: 0 2px 16px rgba(33,150,243,0.08);
    background: #fff;
    padding: 32px 28px 28px 28px;
    margin-bottom: 18px;
  }
  .btn-cart {
    border-radius: 24px;
    font-weight: 600;
    font-size: 1.1rem;
    padding: 10px 28px;
    box-shadow: 0 2px 8px rgba(33,150,243,0.08);
  }
  .review-avatar {
    width: 38px; height: 38px; border-radius: 50%; background: #e3e8ef; display:inline-block; vertical-align:middle; margin-right:10px;
    background-image: url('/do_dien_tu/public/assets/images/user-default.png'); background-size:cover; background-position:center;
  }
  .review-card { border-radius: 16px; box-shadow: 0 2px 12px rgba(33,150,243,0.08); background: #fff; padding: 28px 24px; margin-bottom: 24px; }
  @media (max-width: 768px) {
    .product-info-card { padding: 16px 8px; }
    .review-card { padding: 16px 8px; }
  }
</style>
<div class="container mt-4 mb-5">
  <div class="row g-4">
    <!-- Cột trái: Ảnh + mô tả + giỏ hàng -->
    <div class="col-lg-7 col-md-6 mb-3">
      <div class="bg-white rounded-4 shadow-sm p-4 h-100">
        <div class="row">
          <div class="col-md-5 col-12 mb-3 mb-md-0">
            <img src="/do_dien_tu/public/assets/images/<?php echo htmlspecialchars($product['hinhanh']); ?>"
              class="img-fluid product-img-big w-100"
              alt="Sản phẩm"
              onerror="this.onerror=null;this.src='/do_dien_tu/public/assets/images/no-image.png';">
          </div>
          <div class="col-md-7 col-12">
            <div class="d-flex flex-column justify-content-between h-100">
              <div>
                <h2 class="fw-bold mb-2" style="font-size:2rem; color:#223366;"><?php echo $product['tensp']; ?></h2>
                <div class="mb-2">
                  <span class="fs-3 fw-bold text-danger"><?php echo number_format($product['dongia']); ?> đ</span>
                </div>
                <div class="mb-2 text-muted"><i class="bi bi-box"></i> Kho: <?php echo $product['soluong']; ?> sản phẩm</div>
                <div class="mb-3"><b>Mô tả:</b><br><span class="text-secondary"><?php echo nl2br($product['mota']); ?></span></div>
              </div>
              <form method="POST" action="index.php?controller=cart&action=add" class="mb-2">
                <input type="hidden" name="masp" value="<?php echo $product['masp']; ?>">
                <div class="input-group mb-3" style="max-width: 200px;">
                  <input type="number" name="soluong" value="1" min="1" max="<?php echo $product['soluong']; ?>" class="form-control">
                  <button class="btn btn-success btn-cart" type="submit"><i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Cột phải: Dịch vụ lắp đặt & khuyến mãi -->
    <div class="col-lg-5 col-md-6">
      <?php
        require_once __DIR__ . '/../../models/ProductService.php';
        require_once __DIR__ . '/../../models/ProductPromotion.php';
        $masp = intval($product['masp']);
        $services = ProductService::getByProduct($masp);
        $promotions = ProductPromotion::getByProduct($masp);
      ?>
      <div class="bg-white shadow-sm rounded-4 p-3 mb-3" style="border-left:6px solid #ff9800;">
        <div class="fw-bold text-orange mb-2" style="font-size:1.2rem;"><i class="bi bi-fire"></i> Dịch vụ lắp đặt</div>
        <?php if (mysqli_num_rows($services) > 0): ?>
          <?php $first = true; while ($sv = mysqli_fetch_assoc($services)): ?>
            <div class="bg-light rounded-3 p-2 mb-2 border">
              <div class="form-check mb-1">
                <input class="form-check-input" type="radio" name="dichvu" <?php if($first){echo 'checked';$first=false;} ?> disabled>
                <label class="form-check-label w-100">
                  <span class="fw-bold"><?php echo htmlspecialchars($sv['ten_goi']); ?></span>
                  <?php if($sv['giacu']): ?><span class="text-decoration-line-through text-muted ms-2"><?php echo number_format($sv['giacu']); ?>đ</span><?php endif; ?>
                  <?php if($sv['giamoi']): ?><span class="fw-bold text-danger ms-2"><?php echo number_format($sv['giamoi']); ?>đ</span><?php endif; ?><br>
                  <?php if($sv['dacdiem']): ?>
                    <ul class="mb-0 mt-1 ps-4">
                      <?php foreach(explode("\n", $sv['dacdiem']) as $feat): if(trim($feat)): ?>
                        <li><span class="text-success"><i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($feat); ?></span></li>
                      <?php endif; endforeach; ?>
                    </ul>
                  <?php endif; ?>
                </label>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="alert alert-warning mb-0">Chưa có dịch vụ lắp đặt cho sản phẩm này.</div>
        <?php endif; ?>
      </div>
      <div class="bg-white shadow-sm rounded-4 p-3" style="border-left:6px solid #2196f3;">
        <div class="fw-bold text-primary mb-2" style="font-size:1.1rem;">🎁 Khuyến mãi</div>
        <?php if (mysqli_num_rows($promotions) > 0): ?>
          <ul class="mb-2 ps-4">
            <?php while ($km = mysqli_fetch_assoc($promotions)): ?>
              <li><?php echo htmlspecialchars($km['noidung']); ?></li>
            <?php endwhile; ?>
          </ul>
        <?php else: ?>
          <div class="alert alert-info mb-0">Chưa có khuyến mãi cho sản phẩm này.</div>
        <?php endif; ?>
        <div class="alert alert-warning py-2 px-3 mb-1"><i class="bi bi-truck"></i> Giao hàng nhanh chóng (tùy khu vực)</div>
        <div class="alert alert-warning py-2 px-3"><i class="bi bi-exclamation-triangle"></i> Mỗi số điện thoại chỉ mua 3 sản phẩm trong 1 tháng</div>
      </div>
    </div>
  </div>
  </div>
</div>

  <!-- ĐÁNH GIÁ & BÌNH LUẬN -->
  <?php
    $masp = intval($product['masp']);
    // Lấy tất cả đánh giá sản phẩm
    $sql_reviews = "SELECT dg.*, kh.tenkh FROM danhgia dg JOIN khachhang kh ON dg.makh = kh.makh WHERE masp=$masp ORDER BY thoigian DESC";
    $rs_reviews = mysqli_query($GLOBALS['conn'], $sql_reviews);
    $reviews = [];
    $star_count = [1=>0,2=>0,3=>0,4=>0,5=>0];
    $total_score = 0;
    while ($r = mysqli_fetch_assoc($rs_reviews)) {
      $reviews[] = $r;
      $star_count[$r['diem']]++;
      $total_score += $r['diem'];
    }
    $total_reviews = count($reviews);
    $avg_score = $total_reviews ? round($total_score/$total_reviews,1) : 0;
    // Kiểm tra user đã từng mua và nhận hàng sp này chưa để cho phép đánh giá
    $can_review = false;
    $my_review = null;
    if (isset($_SESSION['user'])) {
      $makh = intval($_SESSION['user']['makh']);
      $sql_check = "SELECT ct.madon FROM chitietdonhang ct JOIN donhang d ON ct.madon=d.madon WHERE ct.masp=$masp AND d.makh=$makh AND d.trangthai=4 LIMIT 1";
      $rs_check = mysqli_query($GLOBALS['conn'], $sql_check);
      if (mysqli_num_rows($rs_check)>0) {
        // Đã mua và nhận hàng
        $can_review = true;
        // Đã đánh giá chưa?
        $sql_my = "SELECT * FROM danhgia WHERE makh=$makh AND masp=$masp LIMIT 1";
        $rs_my = mysqli_query($GLOBALS['conn'], $sql_my);
        if ($rv_my = mysqli_fetch_assoc($rs_my)) $my_review = $rv_my;
      }
    }
  ?>
  <div class="mt-5 mb-4 p-4 bg-white rounded-4 shadow-sm">
    <h4 class="mb-3"><b>Đánh giá và bình luận</b></h4>
    <div class="row align-items-center mb-3">
      <div class="col-md-3 text-center">
        <div style="font-size:2.2rem;font-weight:700;color:#ff9800;">
          <?php echo $avg_score; ?> <i class="bi bi-star-fill"></i>
        </div>
        <div class="text-muted"><?php echo $total_reviews; ?> đánh giá</div>
      </div>
      <div class="col-md-9">
        <?php for($s=5;$s>=1;$s--): ?>
          <a href="#" class="badge bg-white border text-dark me-2" onclick="event.preventDefault();filterStars(this,<?php echo $masp; ?>,<?php echo $s; ?>)"><?php echo $s; ?> <i class="bi bi-star-fill text-warning"></i> (<?php echo $star_count[$s]; ?>)</a>
        <?php endfor; ?>
        <a href="#" class="badge bg-danger text-white ms-2" onclick="event.preventDefault();filterStars(this,<?php echo $masp; ?>,0)">Tất cả</a>
      </div>
    </div>
    <div id="review-list-<?php echo $masp; ?>">
      <?php if ($total_reviews==0): ?>
        <div class="alert alert-warning">Trở thành người đầu tiên đánh giá về sản phẩm.</div>
      <?php else: ?>
        <?php foreach ($reviews as $rv): ?>
          <div class="review-card-outer mb-4">
            <div class="d-flex align-items-start gap-3">
              <div class="review-avatar" style="background-image:url('/do_dien_tu/public/assets/images/user-default.png');"></div>
              <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-2 mb-1">
                  <b class="text-dark" style="font-size:1.08rem;"><?php echo htmlspecialchars($rv['tenkh']); ?></b>
                  <span class="ms-1 text-warning">
                    <?php for($i=1;$i<=5;$i++) echo $i<=$rv['diem']?'<i class=\"bi bi-star-fill\"></i>':'<i class=\"bi bi-star\"></i>'; ?>
                  </span>
                  <span class="text-muted ms-2" style="font-size:12px"><?php echo date('d/m/Y H:i',strtotime($rv['thoigian'])); ?></span>
                </div>
                <div class="review-content fs-6 mb-2 text-dark"> <?php echo nl2br(htmlspecialchars($rv['noidung'])); ?> </div>
                <?php if (!empty($rv['admin_reply'])): ?>
                  <div class="admin-reply-box d-flex align-items-start gap-2 mt-2 animate__animated animate__fadeIn">
                    <div class="shop-avatar flex-shrink-0" style="width:32px;height:32px;border-radius:50%;background:#e3e8ef;display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:#fff;background-image:url('/do_dien_tu/public/assets/images/shop-avatar.png');background-size:cover;background-position:center;">
                      <i class="bi bi-shop text-primary"></i>
                    </div>
                    <div class="admin-reply-content bg-primary bg-opacity-10 border border-primary rounded-3 px-3 py-2 shadow-sm">
                      <span class="fw-bold text-primary"><i class="bi bi-shop"></i> Phản hồi từ shop:</span>
                      <span class="text-dark ms-1"> <?php echo nl2br(htmlspecialchars($rv['admin_reply'])); ?> </span>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <style>
            .review-card-outer {transition:box-shadow .2s,transform .2s; border-radius:16px; box-shadow:0 2px 8px rgba(33,150,243,0.08); background:#fff; padding:18px 18px 10px 18px;}
            .review-card-outer:hover {box-shadow:0 8px 28px rgba(33,150,243,0.13); transform:translateY(-2px) scale(1.01);}
            .review-avatar {width:38px;height:38px;border-radius:50%;background:#e3e8ef url('/do_dien_tu/public/assets/images/user-default.png') center/cover no-repeat;}
            .admin-reply-box .shop-avatar {background:#fff;border:2px solid #0d6efd;}
            .admin-reply-content {font-size:0.98rem;}
            @media (max-width: 768px) {
              .review-card-outer {padding:10px 4px 6px 8px;}
              .admin-reply-content {font-size:0.94rem;}
            }
          </style>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <?php if ($can_review && !$my_review): ?>
      <form method="post" class="mt-3">
        <input type="hidden" name="action" value="danhgia">
        <input type="hidden" name="masp" value="<?php echo $masp; ?>">
        <div class="mb-2">
          <b>Đánh giá của bạn:</b>
          <span id="star-select-<?php echo $masp; ?>">
            <?php for($i=1;$i<=5;$i++): ?>
              <input type="radio" name="diem" value="<?php echo $i; ?>" id="star-<?php echo $masp.'-'.$i; ?>" required>
              <label for="star-<?php echo $masp.'-'.$i; ?>" style="color:orange;font-size:20px;cursor:pointer;">&#9733;</label>
            <?php endfor; ?>
          </span>
        </div>
        <div class="mb-2">
          <textarea name="noidung" class="form-control" rows="2" maxlength="1000" placeholder="Nhập nội dung bình luận..." required></textarea>
        </div>
        <button class="btn btn-danger" type="submit">Gửi đánh giá</button>
      </form>
    <?php elseif ($my_review): ?>
      <div class="alert alert-success mt-2">Bạn đã đánh giá sản phẩm này.</div>
    <?php endif; ?>
  </div>

  <!-- SẢN PHẨM TƯƠNG TỰ -->
  <?php
  require_once 'models/Product.php';
  $maloai = isset($product['maloai']) ? intval($product['maloai']) : 0;
  $masp = intval($product['masp']);
  $relates = [];
  if ($maloai) {
    $rs = Product::getByCategory($maloai);
    while ($sp = mysqli_fetch_assoc($rs)) {
      if ($sp['masp'] != $masp) $relates[] = $sp;
      if (count($relates) >= 6) break;
    }
  $rs = Product::getByCategory($maloai);
  while ($sp = mysqli_fetch_assoc($rs)) {
    if ($sp['masp'] != $masp) $relates[] = $sp;
    if (count($relates) >= 6) break;
  }
}
?>
<?php if (count($relates)): ?>
<div class="mt-5">
  <h4 class="mb-3 fw-bold text-primary">Sản phẩm tương tự</h4>
  <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3">
    <?php foreach($relates as $sp): ?>
      <div class="col">
        <div class="card h-100 shadow-sm border-0 rounded-4">
          <a href="index.php?controller=product&action=detail&id=<?php echo $sp['masp']; ?>" class="text-decoration-none">
            <img src="/do_dien_tu/public/assets/images/<?php echo htmlspecialchars($sp['hinhanh']); ?>" class="card-img-top p-2" alt="<?php echo htmlspecialchars($sp['tensp']); ?>" style="height:110px;object-fit:contain;border-radius:16px;">
            <div class="card-body py-2 px-2">
              <div class="fw-bold text-dark" style="font-size:0.97rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?php echo $sp['tensp']; ?></div>
              <div class="text-danger fw-bold mb-1" style="font-size:1.05rem;"><?php echo number_format($sp['dongia']); ?> đ</div>
            </div>
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php endif; ?>

<?php include 'views/layout/footer.php'; ?>
