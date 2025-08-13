<?php include 'views/layout/header.php'; ?>

<div class="container mt-4 pattern-bg" style="border-radius:2.5rem;">
  <div class="main-bg-section" style="margin-top:0;">

  <h3>Giỏ hàng của bạn</h3>

  <?php if (!empty($_SESSION['cart'])): ?>
  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>Hình ảnh</th>
        <th>Tên sản phẩm</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Thành tiền</th>
        <th></th>
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
            <img src="/do_dien_tu/public/assets/images/<?php echo htmlspecialchars($product['hinhanh']); ?>"
                 alt="<?php echo htmlspecialchars($item['tensp']); ?>"
                 style="width:64px;height:64px;object-fit:cover;border-radius:12px;box-shadow:0 2px 8px rgba(33,150,243,0.10);background:#f6fafd;"
                 onerror="this.onerror=null;this.src='/do_dien_tu/public/assets/images/no-image.png';">
          <?php else: ?>
            <span class="text-secondary">Không có ảnh</span>
          <?php endif; ?>
        </td>
        <td class="fw-bold"> <?php echo htmlspecialchars($item['tensp']); ?> </td>
        <td><?php echo number_format($item['dongia']); ?> đ</td>
        <td>
          <a href="index.php?controller=cart&action=decrease&id=<?php echo $item['masp']; ?>" class="btn btn-outline-secondary btn-sm">-</a>
          <span class="badge bg-primary mx-1"><?php echo $item['soluong']; ?></span>
          <a href="index.php?controller=cart&action=increase&id=<?php echo $item['masp']; ?>" class="btn btn-outline-secondary btn-sm">+</a>
        </td>
        <td class="text-danger fw-bold"><?php echo number_format($item['dongia'] * $item['soluong']); ?> đ</td>
        <td><a href="index.php?controller=cart&action=remove&id=<?php echo $item['masp']; ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Xoá</a></td>
      </tr>
      <?php $tong += $item['dongia'] * $item['soluong']; endforeach; ?>
      <tr class="table-info">
        <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
        <td colspan="2"><?php echo number_format($tong); ?> đ</td>
      </tr>
    </tbody>
  </table>

  <div class="d-flex justify-content-between">
    <a href="index.php?controller=cart&action=clear" class="btn btn-warning">Xoá toàn bộ</a>
    <a href="index.php?controller=order&action=checkout" class="btn btn-success">Đặt hàng</a>
  </div>

  <?php else: ?>
    <div class="alert alert-info">Giỏ hàng của bạn đang trống.</div>
  <?php endif; ?>
</div>

  </div>
<?php include 'views/layout/footer.php'; ?>
