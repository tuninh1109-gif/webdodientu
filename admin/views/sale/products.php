<?php
include(__DIR__ . '/../../../config/db.php');

// --- Lấy thông tin chương trình Sale ---
$sale = null;
$sale_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($sale_id > 0) {
    $result = mysqli_query($conn, "SELECT * FROM sales WHERE id = $sale_id");
    $sale = mysqli_fetch_assoc($result);
}
// --- Xử lý thêm sản phẩm vào chương trình Sale ---
// --- Hiển thị alert dựa vào msg trên URL ---
$alert = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'add_success') $alert = '<div class="alert alert-success">Thêm sản phẩm vào chương trình thành công!</div>';
    if ($_GET['msg'] === 'delete_success') $alert = '<div class="alert alert-success">Đã xóa sản phẩm khỏi chương trình!</div>';
    if ($_GET['msg'] === 'add_fail') $alert = '<div class="alert alert-danger">Thêm sản phẩm thất bại!</div>';
}
// --- Xử lý thêm sản phẩm vào chương trình Sale ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $sale_price = intval($_POST['sale_price']);
    $quantity = intval($_POST['quantity']);
    $sql = "INSERT INTO sale_products (sale_id, product_id, sale_price, quantity) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiii", $sale_id, $product_id, $sale_price, $quantity);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php?page=sale_products&id=$sale_id&msg=add_success");
        exit;
    } else {
        header("Location: index.php?page=sale_products&id=$sale_id&msg=add_fail");
        exit;
    }
}
// --- Xử lý xóa sản phẩm khỏi chương trình Sale ---
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM sale_products WHERE id = $delete_id AND sale_id = $sale_id");
    header("Location: index.php?page=sale_products&id=$sale_id&msg=delete_success");
    exit;
}
// --- Lấy danh sách sản phẩm đã thuộc chương trình Sale ---
$sale_products = mysqli_query($conn, "SELECT sp.*, p.tensp, p.hinhanh, p.dongia FROM sale_products sp JOIN sanpham p ON sp.product_id = p.masp WHERE sp.sale_id = $sale_id");
// --- Lấy danh sách sản phẩm chưa thuộc chương trình Sale này ---
$all_products = mysqli_query($conn, "SELECT * FROM sanpham WHERE masp NOT IN (SELECT product_id FROM sale_products WHERE sale_id = $sale_id)");
?>
<div class="container mt-4">
  <h2>Quản lý sản phẩm Sale: <?php echo htmlspecialchars($sale['title'] ?? ''); ?></h2>
  <?php if ($alert): ?>
    <div id="alert-box"><?php echo $alert; ?></div>
    <script>setTimeout(function(){ document.getElementById('alert-box').style.display = 'none'; }, 3000);</script>
  <?php endif; ?>
  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#product-select').select2({
        width: '100%',
        placeholder: "Tìm kiếm sản phẩm...",
        allowClear: true
      });
      // Hiển thị giá gốc và gợi ý giá sale khi chọn sản phẩm
      $('#product-select').on('change', function() {
        var price = $('#product-select option:selected').data('price');
        if (price) {
          $('#original-price').val(Number(price).toLocaleString('vi-VN') + '₫');
          // Gợi ý giá sale giảm 10%
          var suggest = Math.round(price * 0.9 / 1000) * 1000; // Làm tròn nghìn
          $('#sale-price').val(suggest);
          $('#sale-price-warning').text('');
        } else {
          $('#original-price').val('');
          $('#sale-price').val('');
          $('#sale-price-warning').text('');
        }
      });
      // Cảnh báo nếu giá sale >= giá gốc
      $('#sale-price').on('input', function() {
        var price = $('#product-select option:selected').data('price');
        var sale = parseInt($(this).val() || 0);
        if (price && sale >= price) {
          $('#sale-price-warning').text('Giá sale phải nhỏ hơn giá gốc!').css('color','red');
        } else {
          $('#sale-price-warning').text('');
        }
      });
    });
  </script>
  <form method="post" class="mb-4">
    <input type="hidden" name="sale_id" value="<?php echo $sale_id; ?>">
    <div class="row g-2 align-items-end">
      <div class="col-md-5">
        <label class="form-label">Chọn sản phẩm</label>
        <select name="product_id" class="form-select" required id="product-select">
  <option value="">-- Chọn sản phẩm --</option>
  <?php while ($p = mysqli_fetch_assoc($all_products)): ?>
    <option value="<?php echo $p['masp']; ?>" data-price="<?php echo $p['dongia']; ?>">
      <?php echo htmlspecialchars($p['tensp']); ?>
    </option>
  <?php endwhile; ?>
</select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Giá gốc</label>
        <input type="text" id="original-price" class="form-control" readonly placeholder="Chọn sản phẩm">
      </div>
      <div class="col-md-3">
        <label class="form-label">Giá sale</label>
        <input type="number" name="sale_price" class="form-control" required id="sale-price">
        <div id="sale-price-warning" style="font-size:13px;"></div>
      </div>
      <div class="col-md-2">
        <label class="form-label">Số lượng sale</label>
        <input type="number" name="quantity" class="form-control">
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-success">Thêm sản phẩm</button>
      </div>
    </div>
  </form>
  <h4 class="mt-4">Danh sách sản phẩm trong chương trình</h4>
  <table class="table table-bordered align-middle">
    <thead class="table-light">
      <tr>
        <th>Ảnh</th>
        <th>Tên sản phẩm</th>
        <th>Giá gốc</th>
        <th>Giá sale</th>
        <th>Số lượng sale</th>
        <th>Trạng thái</th>
        <th>Ngày thêm</th>
        <th>Xóa</th>
      </tr>
    </thead>
    <tbody>
      <?php if (mysqli_num_rows($sale_products) == 0): ?>
        <tr><td colspan="8" class="text-center">Chưa có sản phẩm nào</td></tr>
      <?php else: ?>
        <?php while ($sp = mysqli_fetch_assoc($sale_products)): ?>
          <tr>
            <td>
              <?php if (!empty($sp['hinhanh'])): ?>
                <img src="../uploads/<?php echo htmlspecialchars($sp['hinhanh']); ?>" width="60" style="object-fit:cover;">
              <?php else: ?>
                <span class="text-muted">Không có ảnh</span>
              <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($sp['tensp']); ?></td>
            <td><span class="text-muted"><?php echo number_format($sp['dongia']); ?>₫</span></td>
            <td>
              <form method="post" style="display:inline-flex;gap:4px;align-items:center;">
                <input type="hidden" name="edit_id" value="<?php echo $sp['id']; ?>">
                <input type="number" name="edit_sale_price" value="<?php echo $sp['sale_price']; ?>" style="width:90px;" class="form-control form-control-sm" required>
                <button type="submit" class="btn btn-outline-primary btn-sm" title="Cập nhật giá sale"><i class="bi bi-save"></i> Lưu</button>
              </form>
            </td>
            <td>
              <form method="post" style="display:inline-flex;gap:4px;align-items:center;">
                <input type="hidden" name="edit_id" value="<?php echo $sp['id']; ?>">
                <input type="number" name="edit_quantity" value="<?php echo $sp['quantity']; ?>" style="width:70px;" class="form-control form-control-sm">
                <button type="submit" class="btn btn-outline-primary btn-sm" title="Cập nhật số lượng"><i class="bi bi-save"></i> Lưu</button>
              </form>
            </td>
            <td>
              <?php if ($sp['quantity'] > 0): ?>
                <span class="badge bg-success">Còn hàng</span>
              <?php else: ?>
                <span class="badge bg-secondary">Hết hàng</span>
              <?php endif; ?>
            </td>
            <td><?php echo isset($sp['created_at']) ? date('d/m/Y H:i', strtotime($sp['created_at'])) : '-'; ?></td>
            <td>
              <a href="?page=sale_products&id=<?php echo $sale_id; ?>&delete_id=<?php echo $sp['id']; ?>" onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này khỏi chương trình?')" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Xóa</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php endif; ?>
    </tbody>
  </table>

    <thead>
      <tr>
        <th>ID</th>
        <th>Tên sản phẩm</th>
        <th>Ảnh</th>
        <th>Giá sale</th>
        <th>Số lượng sale</th>
        <th>Hành động</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($sp = mysqli_fetch_assoc($sale_products)): ?>
      <tr>
        <td><?php echo $sp['id']; ?></td>
        <td><?php echo htmlspecialchars($sp['tensp']); ?></td>
        <td><img src="/do_dien_tu/public/assets/images/<?php echo $sp['hinhanh']; ?>" style="height:40px;"></td>
        <td><?php echo number_format($sp['sale_price']); ?> đ</td>
        <td><?php echo $sp['quantity']; ?></td>
        <td>
          <form method="post" action="index.php?controller=sale&action=update_product" class="d-inline">
            <input type="hidden" name="id" value="<?php echo $sp['id']; ?>">
            <input type="hidden" name="sale_id" value="<?php echo $sale['id']; ?>">
            <input type="number" name="sale_price" value="<?php echo $sp['sale_price']; ?>" style="width:80px;">
            <input type="number" name="quantity" value="<?php echo $sp['quantity']; ?>" style="width:60px;">
            <button class="btn btn-warning btn-sm">Cập nhật</button>
          </form>
          <a href="index.php?controller=sale&action=delete_product&id=<?php echo $sp['id']; ?>&sale_id=<?php echo $sale['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa sản phẩm này khỏi sale?');">Xóa</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <a href="index.php?controller=sale&action=index" class="btn btn-secondary">Quay lại danh sách Sale</a>
</div>
<?php include '../views/layout/footer.php'; ?>
