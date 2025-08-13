<?php include 'views/layout/header.php'; ?>

<div class="container mt-4 pattern-bg" style="border-radius:2.5rem;">
  <div class="row gx-4">
    <div class="col-12">
      <!-- Banner lớn (giống FPT Shop) -->
      <?php // Đã tắt debug bannerArr, carousel sẽ hiển thị bình thường ?>
<?php if (!empty($bannerArr)): ?>
  <div id="bannerCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
    <div class="carousel-inner">
      <?php foreach ($bannerArr as $i => $banner): ?>
        <div class="carousel-item<?php echo ($i === 0) ? ' active' : ''; ?>">
          <img src="/do_dien_tu/public/uploads/<?php echo htmlspecialchars(!empty($banner['image_url']) ? $banner['image_url'] : 'no-image.png'); ?>" class="banner w-100" alt="<?php echo htmlspecialchars($banner['title']); ?>">
        </div>
      <?php endforeach; ?>
    </div>
    <?php if (count($bannerArr) > 1): ?>
      <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    <?php endif; ?>
  </div>
<?php endif; ?>
      <?php include 'views/home/_category_grid.php'; ?>
      <?php include 'views/home/_sale_section.php'; ?>

  <!-- Sản phẩm mới -->
  <div class="section-title">Sản phẩm mới</div>
  <div class="row">
    <?php if (isset($products_new)): foreach ($products_new as $row): ?>
      <div class="col-md-3 mb-4">
        <div class="card card-product h-100">
          <img src="/do_dien_tu/public/assets/images/<?php echo htmlspecialchars($row['hinhanh']); ?>"
     class="card-img-top rounded-top-4 product-thumb"
     alt="<?php echo htmlspecialchars($row['tensp']); ?>"
     style="height:200px;object-fit:cover;"
     onerror="this.onerror=null;this.src='/do_dien_tu/public/assets/images/no-image.png';">
          <div class="card-body">
            <h5 class="card-title mb-1"><?php echo htmlspecialchars($row['tensp']); ?></h5>
            <div class="product-price mb-2"><?php echo number_format($row['dongia']); ?> đ</div>
            <a href="index.php?controller=product&action=detail&id=<?php echo $row['masp']; ?>" class="btn btn-view-detail btn-sm mt-auto w-100">Xem chi tiết</a>
          </div>
        </div>
      </div>
    <?php endforeach; endif; ?>
  </div>

  <!-- Sản phẩm nổi bật -->
  <div class="section-title mt-5">Sản phẩm nổi bật <span class="product-badge">Hot</span></div>
  <div class="row">
    <?php if (isset($products_hot)): foreach ($products_hot as $row): ?>
      <div class="col-md-3 mb-4">
        <div class="card card-product h-100 border-warning">
          <img src="/do_dien_tu/public/assets/images/<?php echo htmlspecialchars($row['hinhanh']); ?>"
     class="card-img-top rounded-top-4 product-thumb"
     alt="<?php echo htmlspecialchars($row['tensp']); ?>"
     style="height:200px;object-fit:cover;"
     onerror="this.onerror=null;this.src='/do_dien_tu/public/assets/images/no-image.png';">
          <div class="card-body">
            <h5 class="card-title mb-1"><?php echo htmlspecialchars($row['tensp']); ?> <span class="badge bg-warning text-dark">Nổi bật</span></h5>
            <div class="product-price mb-2"><?php echo number_format($row['dongia']); ?> đ</div>
            <a href="index.php?controller=product&action=detail&id=<?php echo $row['masp']; ?>" class="btn btn-view-detail btn-sm mt-auto w-100">Xem chi tiết</a>
          </div>
        </div>
      </div>
    <?php endforeach; endif; ?>
  </div>

  <!-- Danh mục Tivi -->
  <div class="section-title mt-5">Tivi <a href="index.php?controller=product&action=category&maloai=1" class="btn btn-viewall float-end">Xem tất cả</a></div>
  <div class="row">
    <?php if (isset($products_tivi)): foreach ($products_tivi as $row): ?>
      <div class="col-md-3 mb-4">
        <div class="card card-product h-100">
          <img src="/do_dien_tu/public/assets/images/<?php echo htmlspecialchars($row['hinhanh']); ?>"
     class="card-img-top rounded-top-4 product-thumb"
     alt="<?php echo htmlspecialchars($row['tensp']); ?>"
     style="height:200px;object-fit:cover;"
     onerror="this.onerror=null;this.src='/do_dien_tu/public/assets/images/no-image.png';">
          <div class="card-body">
            <h5 class="card-title mb-1"><?php echo htmlspecialchars($row['tensp']); ?></h5>
            <div class="product-price mb-2"><?php echo number_format($row['dongia']); ?> đ</div>
            <a href="index.php?controller=product&action=detail&id=<?php echo $row['masp']; ?>" class="btn btn-view-detail btn-sm mt-auto w-100">Xem chi tiết</a>
          </div>
        </div>
      </div>
    <?php endforeach; endif; ?>
  </div>

  <!-- Danh mục Tủ lạnh -->
  <div class="section-title mt-5">Tủ lạnh <a href="index.php?controller=product&action=category&maloai=2" class="btn btn-viewall float-end">Xem tất cả</a></div>
  <div class="row">
    <?php if (isset($products_tulanh)): foreach ($products_tulanh as $row): ?>
      <div class="col-md-3 mb-4">
        <div class="card card-product h-100">
          <img src="/do_dien_tu/public/assets/images/<?php echo htmlspecialchars($row['hinhanh']); ?>"
     class="card-img-top rounded-top-4 product-thumb"
     alt="<?php echo htmlspecialchars($row['tensp']); ?>"
     style="height:200px;object-fit:cover;"
     onerror="this.onerror=null;this.src='/do_dien_tu/public/assets/images/no-image.png';">
          <div class="card-body">
            <h5 class="card-title mb-1"><?php echo htmlspecialchars($row['tensp']); ?></h5>
            <div class="product-price mb-2"><?php echo number_format($row['dongia']); ?> đ</div>
            <a href="index.php?controller=product&action=detail&id=<?php echo $row['masp']; ?>" class="btn btn-view-detail btn-sm mt-auto w-100">Xem chi tiết</a>
          </div>
        </div>
      </div>
    <?php endforeach; endif; ?>
  </div>

  <!-- Máy giặt -->
  <div class="section-title mt-5">Máy giặt <a href="index.php?controller=product&action=category&maloai=3" class="btn btn-viewall float-end">Xem tất cả</a></div>
  <div class="row">
    <?php if (isset($products_maygiat)): foreach ($products_maygiat as $row): ?>
      <div class="col-md-3 mb-4">
        <div class="card card-product h-100">
          <img src="/do_dien_tu/public/assets/images/<?php echo htmlspecialchars($row['hinhanh']); ?>"
     class="card-img-top rounded-top-4 product-thumb"
     alt="<?php echo htmlspecialchars($row['tensp']); ?>"
     style="height:200px;object-fit:cover;"
     onerror="this.onerror=null;this.src='/do_dien_tu/public/assets/images/no-image.png';">
          <div class="card-body">
            <h5 class="card-title mb-1"><?php echo htmlspecialchars($row['tensp']); ?></h5>
            <div class="product-price mb-2"><?php echo number_format($row['dongia']); ?> đ</div>
            <a href="index.php?controller=product&action=detail&id=<?php echo $row['masp']; ?>" class="btn btn-view-detail btn-sm mt-auto w-100">Xem chi tiết</a>
          </div>
        </div>
      </div>
    <?php endforeach; endif; ?>
  </div>

  <!-- Điều hòa -->
  <div class="section-title mt-5">Điều hòa <a href="index.php?controller=product&action=category&maloai=4" class="btn btn-viewall float-end">Xem tất cả</a></div>
  <div class="row">
    <?php if (isset($products_dieuhoa)): foreach ($products_dieuhoa as $row): ?>
      <div class="col-md-3 mb-4">
        <div class="card card-product h-100">
          <img src="/do_dien_tu/public/assets/images/<?php echo htmlspecialchars($row['hinhanh']); ?>"
     class="card-img-top rounded-top-4 product-thumb"
     alt="<?php echo htmlspecialchars($row['tensp']); ?>"
     style="height:200px;object-fit:cover;"
     onerror="this.onerror=null;this.src='/do_dien_tu/public/assets/images/no-image.png';">
          <div class="card-body">
            <h5 class="card-title mb-1"><?php echo htmlspecialchars($row['tensp']); ?></h5>
            <div class="product-price mb-2"><?php echo number_format($row['dongia']); ?> đ</div>
            <a href="index.php?controller=product&action=detail&id=<?php echo $row['masp']; ?>" class="btn btn-view-detail btn-sm mt-auto w-100">Xem chi tiết</a>
          </div>
        </div>
      </div>
    <?php endforeach; endif; ?>
  </div>

  <!-- Điện thoại -->
  <div class="section-title mt-5">Điện thoại <a href="index.php?controller=product&action=category&maloai=5" class="btn btn-viewall float-end">Xem tất cả</a></div>
  <div class="row">
    <?php if (isset($products_dienthoai)): foreach ($products_dienthoai as $row): ?>
      <div class="col-md-3 mb-4">
        <div class="card card-product h-100">
          <img src="/do_dien_tu/public/assets/images/<?php echo htmlspecialchars($row['hinhanh']); ?>"
     class="card-img-top rounded-top-4 product-thumb"
     alt="<?php echo htmlspecialchars($row['tensp']); ?>"
     style="height:200px;object-fit:cover;"
     onerror="this.onerror=null;this.src='/do_dien_tu/public/assets/images/no-image.png';">
          <div class="card-body">
            <h5 class="card-title mb-1"><?php echo htmlspecialchars($row['tensp']); ?></h5>
            <div class="product-price mb-2"><?php echo number_format($row['dongia']); ?> đ</div>
            <a href="index.php?controller=product&action=detail&id=<?php echo $row['masp']; ?>" class="btn btn-view-detail btn-sm mt-auto w-100">Xem chi tiết</a>
          </div>
        </div>
      </div>
    <?php endforeach; endif; ?>
  </div>

  <!-- Máy tính xách tay -->
  <div class="section-title mt-5">Máy tính xách tay <a href="index.php?controller=product&action=category&maloai=6" class="btn btn-viewall float-end">Xem tất cả</a></div>
  <div class="row">
    <?php if (isset($products_laptop)): foreach ($products_laptop as $row): ?>
      <div class="col-md-3 mb-4">
        <div class="card card-product h-100">
          <img src="/do_dien_tu/public/assets/images/<?php echo htmlspecialchars($row['hinhanh']); ?>"
     class="card-img-top rounded-top-4 product-thumb"
     alt="<?php echo htmlspecialchars($row['tensp']); ?>"
     style="height:200px;object-fit:cover;"
     onerror="this.onerror=null;this.src='/do_dien_tu/public/assets/images/no-image.png';">
          <div class="card-body">
            <h5 class="card-title mb-1"><?php echo htmlspecialchars($row['tensp']); ?></h5>
            <div class="product-price mb-2"><?php echo number_format($row['dongia']); ?> đ</div>
            <a href="index.php?controller=product&action=detail&id=<?php echo $row['masp']; ?>" class="btn btn-view-detail btn-sm mt-auto w-100">Xem chi tiết</a>
          </div>
        </div>
      </div>
    <?php endforeach; endif; ?>
  </div>

</div>

  </div>
<?php include 'views/layout/footer.php'; ?>
