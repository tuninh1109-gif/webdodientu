<?php include 'views/layout/header.php'; ?>

<div class="container mt-4">
  <h3>Sản phẩm theo danh mục</h3>

  <?php if (!empty($brands)): ?>
  <div class="brand-filter mb-4 d-flex align-items-center gap-3 flex-wrap">
    <?php foreach ($brands as $brand): ?>
      <a href="index.php?controller=product&action=category&maloai=<?php echo $maloai; ?>&math=<?php echo $brand['math']; ?>"
         class="brand-logo-link<?php if (isset($_GET['math']) && $_GET['math'] == $brand['math']) echo ' active'; ?>"
         title="<?php echo htmlspecialchars($brand['tenthuonghieu']); ?>">
        <?php if (!empty($brand['logo'])): ?>
          <img src="/do_dien_tu/public/assets/brand_logos/<?php echo htmlspecialchars($brand['logo']); ?>"
               alt="<?php echo htmlspecialchars($brand['tenthuonghieu']); ?>"
               class="brand-logo"
               style="height:40px;object-fit:contain;padding:4px;background:#fff;border-radius:8px;border:1px solid #eee;max-width:80px;">
        <?php else: ?>
          <span style="font-size:15px;font-weight:500;padding:7px 16px;display:inline-block;background:#f8f9fa;border-radius:8px;border:1px solid #eee;">
            <?php echo htmlspecialchars($brand['tenthuonghieu']); ?>
          </span>
        <?php endif; ?>
      </a>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
  <div class="row">
    <?php foreach ($products as $row): ?>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
      <div class="card h-100 shadow-sm border-0 rounded-4 product-card position-relative overflow-hidden animate__animated animate__fadeInUp" style="transition:transform .2s;">
        <img src="/do_dien_tu/public/assets/images/<?php echo htmlspecialchars($row['hinhanh']); ?>"
     class="card-img-top rounded-top-4"
     style="height:200px;object-fit:cover;"
     alt="<?php echo htmlspecialchars($row['tensp']); ?>"
     onerror="this.onerror=null;this.src='/do_dien_tu/public/assets/images/no-image.png';">
        <div class="card-body d-flex flex-column">
          <h6 class="card-title text-truncate mb-2" title="<?php echo htmlspecialchars($row['tensp']); ?>">
            <?php echo htmlspecialchars($row['tensp']); ?>
          </h6>
          <span class="badge bg-danger fs-6 mb-2"><?php echo number_format($row['dongia']); ?>₫</span>
          <a href="index.php?controller=product&action=detail&id=<?php echo $row['masp']; ?>" class="btn btn-view-detail btn-sm mt-auto w-100">Xem chi tiết</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <style>
    .product-card:hover { transform: translateY(-6px) scale(1.03); box-shadow:0 8px 32px rgba(0,0,0,0.16)!important; }
    .product-card .badge { letter-spacing:1px; }
  </style>
</div>

<?php include 'views/layout/footer.php'; ?>
