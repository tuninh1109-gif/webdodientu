<div class="container py-4">
  <h4 class="mb-4 fw-bold text-primary"><i class="bi bi-search"></i> Tìm kiếm sản phẩm</h4>

  <!-- FORM LỌC -->
  <form class="row gx-3 gy-2 align-items-end mb-4" method="get" action="index.php">
    <input type="hidden" name="controller" value="product">
    <input type="hidden" name="action" value="search">

    <div class="col-md-3">
      <label class="form-label">Từ khóa</label>
      <input class="form-control" type="search" name="q" value="<?= htmlspecialchars($q ?? '') ?>" placeholder="Nhập tên sản phẩm..." required>
    </div>

    <div class="col-md-2">
      <label class="form-label">Loại sản phẩm</label>
      <select name="maloai" class="form-select">
        <option value="0">Tất cả</option>
        <?php foreach ($loais as $loai): ?>
          <option value="<?= $loai['maloai'] ?>" <?= ($maloai ?? 0) == $loai['maloai'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($loai['tenloai']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-2">
      <label class="form-label">Giá từ</label>
      <input type="number" class="form-control" name="giatu" min="<?= (float)$pricerange['min_price'] ?>" max="<?= (float)$pricerange['max_price'] ?>" value="<?= htmlspecialchars($giatu ?? '') ?>">
    </div>

    <div class="col-md-2">
      <label class="form-label">Đến</label>
      <input type="number" class="form-control" name="giaden" min="<?= (float)$pricerange['min_price'] ?>" max="<?= (float)$pricerange['max_price'] ?>" value="<?= htmlspecialchars($giaden ?? '') ?>">
    </div>

    <div class="col-md-2">
      <label class="form-label">Sắp xếp</label>
      <select name="sort" class="form-select">
        <option value="">Mặc định</option>
        <option value="price_asc" <?= ($sort ?? '') == 'price_asc' ? 'selected' : '' ?>>Giá tăng dần</option>
        <option value="price_desc" <?= ($sort ?? '') == 'price_desc' ? 'selected' : '' ?>>Giá giảm dần</option>
        <option value="newest" <?= ($sort ?? '') == 'newest' ? 'selected' : '' ?>>Mới nhất</option>
      </select>
    </div>

    <div class="col-md-1">
      <button class="btn btn-primary w-100"><i class="bi bi-funnel"></i> Lọc</button>
    </div>
  </form>

  <!-- KẾT QUẢ -->
  <?php if (isset($q) && $q !== ''): ?>
    <p class="mb-3">Kết quả cho từ khóa: <strong class="text-primary"><?= htmlspecialchars($q) ?></strong></p>
  <?php endif; ?>

  <?php if (!empty($products)): ?>
    <div class="row g-4">
      <?php foreach ($products as $product): ?>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="card shadow-sm h-100 border-0 rounded-4 product-card">
            <div class="position-relative overflow-hidden rounded-top-4">
              <img src="/do_dien_tu/public/assets/images/<?= htmlspecialchars($product['hinhanh']) ?>"
                   class="w-100"
                   alt="<?= htmlspecialchars($product['tensp']) ?>"
                   style="height: 200px; object-fit: cover;"
                   onerror="this.src='/do_dien_tu/public/assets/images/no-image.png'">
            </div>
            <div class="card-body d-flex flex-column">
              <h6 class="card-title text-truncate mb-2" title="<?= htmlspecialchars($product['tensp']) ?>">
                <?= htmlspecialchars($product['tensp']) ?>
              </h6>
              <div class="text-danger fw-bold fs-5 mb-2">
                <?= number_format($product['dongia']) ?>₫
              </div>
              <a href="index.php?controller=product&action=detail&id=<?= $product['masp'] ?>"
                 class="btn btn-outline-primary btn-sm mt-auto w-100">
                <i class="bi bi-eye"></i> Xem chi tiết
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- CSS bổ sung -->
    <style>
      .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
        transition: all 0.3s ease-in-out;
      }
    </style>
  <?php else: ?>
    <div class="alert alert-warning">Không tìm thấy sản phẩm phù hợp.</div>
  <?php endif; ?>
</div>
