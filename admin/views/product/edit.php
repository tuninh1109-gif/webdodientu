<?php
// KHÔNG cần session_start vì đã có ở admin/index.php

// Dùng đường dẫn tuyệt đối để tránh lỗi include sai
include(__DIR__ . '/../../../config/db.php');


// Lấy ID sản phẩm từ URL và ép kiểu an toàn
$masp = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Kiểm tra sản phẩm tồn tại
$result = mysqli_query($conn, "SELECT * FROM sanpham WHERE masp = $masp");
$product = mysqli_fetch_assoc($result);

if (!$product) {
  echo "<p class='text-danger'>❌ Không tìm thấy sản phẩm.</p>";
  include(__DIR__ . '/../layout/footer.php');
  exit;
}

// Lấy danh sách loại sản phẩm để chọn
$loaisp_result = mysqli_query($conn, "SELECT * FROM loaisp WHERE trangthai = 1");

// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $tensp = mysqli_real_escape_string($conn, $_POST['tensp']);
  $dongia = (int)$_POST['dongia'];
  $mota = mysqli_real_escape_string($conn, $_POST['mota']);
  $maloai = (int)$_POST['maloai'];

  $math = isset($_POST['math']) ? (int)$_POST['math'] : 0;
  $soluong = (int)$_POST['soluong'];
  $hot = isset($_POST['hot']) ? 1 : 0;
  $sql = "UPDATE sanpham SET tensp='$tensp', dongia=$dongia, mota='$mota', maloai=$maloai, math=$math, soluong=$soluong, hot=$hot WHERE masp = $masp";
  mysqli_query($conn, $sql);

  // Nếu có ảnh mới thì upload lại
  if (!empty($_FILES['image']['name'])) {
    // Lấy tên loại sản phẩm từ maloai
    $tenloai = '';
    $rs_loai = mysqli_query($conn, "SELECT tenloai FROM loaisp WHERE maloai = $maloai LIMIT 1");
    if ($row_loai = mysqli_fetch_assoc($rs_loai)) {
        $tenloai = strtolower(preg_replace('/\s+/', '_', $row_loai['tenloai']));
    }
    if (!$tenloai) $tenloai = 'khac';
    $upload_dir = __DIR__ . "/../../../public/assets/images/$tenloai/";
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    $image_name = basename($_FILES['image']['name']);
    $img_file = strtolower(preg_replace('/\s+/', '_', $image_name));
    move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $img_file);
    // Cập nhật tên file ảnh vào DB
    mysqli_query($conn, "UPDATE sanpham SET hinhanh='$img_file' WHERE masp=$masp");
  }

  // Xử lý dịch vụ lắp đặt
  require_once(__DIR__ . '/../../../models/ProductService.php');

  // Sau khi cập nhật, load lại sản phẩm để lấy đúng loại và ảnh mới nhất
  $result = mysqli_query($conn, "SELECT sanpham.*, loaisp.tenloai FROM sanpham JOIN loaisp ON sanpham.maloai = loaisp.maloai WHERE masp = $masp");
  $product = mysqli_fetch_assoc($result);
  ProductService::deleteByProduct($masp); // Xóa hết dịch vụ cũ
  if (!empty($_POST['service_name'])) {
    $names = $_POST['service_name'];
    $old_prices = $_POST['service_price_old'];
    $new_prices = $_POST['service_price_new'];
    $features = $_POST['service_features'];
    $icons = $_POST['service_icon'];
$descs = $_POST['service_desc'];
for ($i = 0; $i < count($names); $i++) {
  $name = mysqli_real_escape_string($conn, $names[$i]);
  $giacu = (int)$old_prices[$i];
  $giamoi = (int)$new_prices[$i];
  $dacdiem = mysqli_real_escape_string($conn, $features[$i]);
  $icon = mysqli_real_escape_string($conn, $icons[$i]);
  $desc = mysqli_real_escape_string($conn, $descs[$i]);
  if (trim($name) !== "") {
    ProductService::add($masp, $name, $desc, $giacu, $giamoi, $dacdiem, $icon);
  }
}
  }
  // Xử lý khuyến mãi
  require_once(__DIR__ . '/../../../models/ProductPromotion.php');
  ProductPromotion::deleteByProduct($masp); // Xóa hết khuyến mãi cũ
  if (!empty($_POST['promotion_list'])) {
    $promos = explode("\n", $_POST['promotion_list']);
    foreach ($promos as $promo) {
      $promo = trim($promo);
      if ($promo !== "") {
        ProductPromotion::add($masp, mysqli_real_escape_string($conn, $promo));
      }
    }
  }

  header("Location: index.php?page=product");

  exit;
}
?>

<div class="container mt-4">
  <h4>✏️ Sửa sản phẩm</h4>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Tên sản phẩm:</label>
      <input type="text" name="tensp" class="form-control" value="<?php echo htmlspecialchars($product['tensp']); ?>" required>
    </div>
    <div class="mb-3">
      <label>Giá:</label>
      <input type="number" name="dongia" class="form-control" value="<?php echo $product['dongia']; ?>" required>
    </div>
    <div class="mb-3">
      <label>Số lượng:</label>
      <input type="number" name="soluong" class="form-control" value="<?php echo $product['soluong']; ?>" min="0" required>
    </div>
    <div class="mb-3">
      <label><input type="checkbox" name="hot" value="1" <?php if(!empty($product['hot'])) echo 'checked'; ?>> Sản phẩm nổi bật (Hot)</label>
    </div>
    <div class="mb-3">
      <label>Mô tả:</label>
      <textarea name="mota" class="form-control"><?php echo htmlspecialchars($product['mota']); ?></textarea>
    </div>
    <div class="mb-3">
      <label>Ảnh hiện tại:</label><br>
      <?php
$img_dir = isset($product['tenloai']) ? strtolower(preg_replace('/\s+/', '_', $product['tenloai'])) : '';
$img_file = isset($product['hinhanh']) ? $product['hinhanh'] : '';
if ($img_dir && $img_file) {
    $img_path = "/do_dien_tu/public/assets/images/{$img_dir}/{$img_file}";
} else {
    $img_path = "/do_dien_tu/public/assets/images/no-image.png";
}
?>
<img src="<?php echo $img_path; ?>"
     width="120" class="rounded shadow-sm border mb-2"
     onerror="this.onerror=null;this.src='/do_dien_tu/public/assets/images/no-image.png';">
<br>
      <label>Chọn ảnh mới:</label>
      <input type="file" name="image" class="form-control">
    </div>
    <div class="mb-3">
      <label>Loại sản phẩm:</label>
      <select name="maloai" id="maloai-select" class="form-select" required>
        <?php 
        // Lấy lại danh sách loại vì trước đó đã fetch hết
        $loaisp_result2 = mysqli_query($conn, "SELECT * FROM loaisp WHERE trangthai = 1");
        while ($loai = mysqli_fetch_assoc($loaisp_result2)): ?>
          <option value="<?php echo $loai['maloai']; ?>" <?php echo $product['maloai'] == $loai['maloai'] ? 'selected' : ''; ?>>
            <?php echo htmlspecialchars($loai['tenloai']); ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-3" id="brand-select-wrapper">
      <!-- Dropdown thương hiệu sẽ được load ở đây -->
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      const maloaiSelect = document.getElementById('maloai-select');
      const brandWrapper = document.getElementById('brand-select-wrapper');
      const currentBrand = <?php echo isset($product['math']) ? (int)$product['math'] : 'null'; ?>;
      function loadBrandSelect(maloai, selectedMath) {
        if (!maloai) {
          brandWrapper.innerHTML = '';
          return;
        }
        fetch('views/product/_brand_select.php?maloai=' + maloai + (selectedMath ? ('&selected=' + selectedMath) : ''))
          .then(res => res.text())
          .then(html => {
            brandWrapper.innerHTML = html;
          });
      }
      maloaiSelect.addEventListener('change', function() {
        loadBrandSelect(this.value, null);
      });
      // Load lần đầu nếu đã có loại và thương hiệu
      if (maloaiSelect.value) {
        loadBrandSelect(maloaiSelect.value, currentBrand);
      }
    });
    </script>
<!-- Dịch vụ lắp đặt -->
<div class="mb-3">
  <label class="fw-bold">Dịch vụ lắp đặt (có thể nhập nhiều gói):</label>
  <div id="service-list">
    <?php
      require_once(__DIR__ . '/../../../models/ProductService.php');
      $service_result = ProductService::getByProduct($masp);

      if (mysqli_num_rows($service_result) > 0):
        while ($sv = mysqli_fetch_assoc($service_result)):
    ?>
    <div class="service-item border rounded p-2 mb-2 d-flex flex-wrap gap-2 align-items-start">
      <input type="hidden" name="service_id[]" value="<?php echo $sv['id']; ?>">
      <div class="flex-fill">
        <input type="text" name="service_name[]" placeholder="Tên gói dịch vụ" class="form-control mb-1" value="<?php echo htmlspecialchars($sv['ten_goi']); ?>">
        <input type="text" name="service_icon[]" placeholder="Icon (bi bi-...) hoặc URL ảnh" class="form-control mb-1" value="<?php echo isset($sv['icon']) ? htmlspecialchars($sv['icon']) : ''; ?>">
        <input type="text" name="service_price_old[]" placeholder="Giá cũ" class="form-control mb-1" value="<?php echo $sv['giacu']; ?>">
        <input type="text" name="service_price_new[]" placeholder="Giá mới" class="form-control mb-1" value="<?php echo $sv['giamoi']; ?>">
        <textarea name="service_features[]" placeholder="Đặc điểm (mỗi dòng 1 đặc điểm)" class="form-control mb-1"><?php echo htmlspecialchars($sv['dacdiem']); ?></textarea>
        <textarea name="service_desc[]" placeholder="Mô tả chi tiết (nếu có)" class="form-control mb-1"><?php echo htmlspecialchars($sv['mota']); ?></textarea>
      </div>
      <button type="button" onclick="this.parentNode.remove()" class="btn btn-sm btn-danger mt-1">Xóa</button>
    </div>
    <?php
        endwhile;
      else:
    ?>
    <p class="text-muted">Chưa có dịch vụ nào được thêm cho sản phẩm này.</p>
    <?php endif; ?>

    <!-- Mẫu trống để thêm mới -->
    <div class="service-item border rounded p-2 mb-2 d-flex flex-wrap gap-2 align-items-start">
      <div class="flex-fill">
        <input type="text" name="service_name[]" placeholder="Tên gói dịch vụ" class="form-control mb-1">
        <input type="text" name="service_icon[]" placeholder="Icon (bi bi-...) hoặc URL ảnh" class="form-control mb-1">
        <input type="text" name="service_price_old[]" placeholder="Giá cũ" class="form-control mb-1">
        <input type="text" name="service_price_new[]" placeholder="Giá mới" class="form-control mb-1">
        <textarea name="service_features[]" placeholder="Đặc điểm (mỗi dòng 1 đặc điểm)" class="form-control mb-1"></textarea>
        <textarea name="service_desc[]" placeholder="Mô tả chi tiết (nếu có)" class="form-control mb-1"></textarea>
      </div>
      <button type="button" onclick="this.parentNode.remove()" class="btn btn-sm btn-danger mt-1">Xóa</button>
    </div>
  </div>

  <button type="button" onclick="addServiceItem()" class="btn btn-sm btn-outline-primary mt-2">+ Thêm gói dịch vụ</button>
  <div class="form-text">Bạn có thể nhập tên icon Bootstrap (ví dụ: <b>bi bi-tools</b>) hoặc dán link ảnh icon cho từng dịch vụ.</div>
</div>

    <!-- Khuyến mãi -->
    <div class="mb-3">
      <label class="fw-bold">Khuyến mãi (mỗi dòng là 1 ưu đãi):</label>
      <textarea name="promotion_list" rows="4" class="form-control" placeholder="Mỗi dòng là một ưu đãi"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">💾 Lưu</button>
    <a href="/do_dien_tu/admin/index.php?controller=product&action=index" class="btn btn-secondary">Quay lại</a>
  </form>
  <script>
    function addServiceItem() {
      const item = document.createElement('div');
      item.className = 'service-item border rounded p-2 mb-2';
      item.innerHTML = `
        <input type="text" name="service_name[]" placeholder="Tên gói dịch vụ" class="form-control mb-1">
        <input type="text" name="service_price_old[]" placeholder="Giá cũ" class="form-control mb-1">
        <input type="text" name="service_price_new[]" placeholder="Giá mới" class="form-control mb-1">
        <textarea name="service_features[]" placeholder="Đặc điểm (mỗi dòng 1 đặc điểm)" class="form-control"></textarea>
        <button type="button" onclick="this.parentNode.remove()" class="btn btn-sm btn-danger mt-1">Xóa</button>
      `;
      document.getElementById('service-list').appendChild(item);
    }
  </script>
</div>

<?php include(__DIR__ . '/../layout/footer.php'); ?>
