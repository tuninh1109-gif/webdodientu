<?php
// Đảm bảo luôn đúng đường dẫn

include(__DIR__ . '/../../../config/db.php');

// Lấy danh sách loại sản phẩm
$loaisp_result = mysqli_query($conn, "SELECT * FROM loaisp WHERE trangthai = 1");

// Xử lý khi form được submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tensp = mysqli_real_escape_string($conn, $_POST['tensp']);
    $dongia = (int)$_POST['dongia'];
    $mota = mysqli_real_escape_string($conn, $_POST['mota']);
    $maloai = (int)$_POST['maloai'];
    $soluong = isset($_POST['soluong']) ? (int)$_POST['soluong'] : 0;

    // Xử lý ảnh upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_name = basename($_FILES['image']['name']);
        $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png'];
        if (!in_array($ext, $allowed)) {
            echo "<p class='text-danger'>❌ Chỉ chấp nhận ảnh JPG, PNG, JPEG.</p>";
        } else {
            // Lấy tên loại sản phẩm từ maloai
            $tenloai = '';
            $rs_loai = mysqli_query($conn, "SELECT tenloai FROM loaisp WHERE maloai = $maloai LIMIT 1");
            if ($row_loai = mysqli_fetch_assoc($rs_loai)) {
                $tenloai = strtolower(preg_replace('/\s+/', '_', $row_loai['tenloai']));
            }
            if (!$tenloai) $tenloai = 'khac';
            $upload_dir = __DIR__ . "/../../../public/assets/images/$tenloai/";
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            // Sau khi insert lấy masp để đặt tên file
            $sql = "INSERT INTO sanpham (tensp, dongia, mota, maloai, soluong) 
                    VALUES ('$tensp', '$dongia', '$mota', '$maloai', '$soluong')";

            if (mysqli_query($conn, $sql)) {
                $masp = mysqli_insert_id($conn);
                $img_file = $masp . ".jpg";
                move_uploaded_file($image_tmp, $upload_dir . $img_file);
                // Cập nhật tên file ảnh vào DB
                mysqli_query($conn, "UPDATE sanpham SET hinhanh='$img_file' WHERE masp=$masp");
                header("Location: /do_dien_tu/admin/index.php?page=product");
                exit;
            } else {
                echo "<p class='text-danger'>❌ Lỗi khi thêm sản phẩm: " . mysqli_error($conn) . "</p>";
            }
        }
    } else {
        echo "<p class='text-danger'>❌ Chưa chọn ảnh sản phẩm hợp lệ!</p>";
    }
}
?>

<div class="container mt-3">
  <h3>➕ Thêm sản phẩm</h3>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Tên sản phẩm</label>
      <input type="text" name="tensp" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Giá</label>
      <input type="number" name="dongia" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Số lượng</label>
      <input type="number" name="soluong" class="form-control" min="0" value="0" required>
    </div>
    <div class="mb-3">
      <label>Mô tả</label>
      <textarea name="mota" class="form-control" rows="3"></textarea>
    </div>
    <div class="mb-3">
      <label>Ảnh sản phẩm</label>
      <input type="file" name="image" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Loại sản phẩm</label>
      <select name="maloai" id="maloai-select" class="form-select" required>
        <option value="">-- Chọn loại --</option>
        <?php 
        // Lấy lại danh sách loại vì trước đó đã fetch hết
        $loaisp_result2 = mysqli_query($conn, "SELECT * FROM loaisp WHERE trangthai = 1");
        while ($loai = mysqli_fetch_assoc($loaisp_result2)): ?>
          <option value="<?php echo $loai['maloai']; ?>">
            <?php echo htmlspecialchars($loai['tenloai']); ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="mb-3" id="brand-select-wrapper">
      <!-- Dropdown thương hiệu sẽ được load ở đây -->
    </div>
    <button type="submit" class="btn btn-primary">✔️ Thêm</button>
    <a href="index.php" class="btn btn-secondary">↩️ Huỷ</a>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
      const maloaiSelect = document.getElementById('maloai-select');
      const brandWrapper = document.getElementById('brand-select-wrapper');
      maloaiSelect.addEventListener('change', function() {
        const maloai = this.value;
        if (!maloai) {
          brandWrapper.innerHTML = '';
          return;
        }
        fetch('views/product/_brand_select.php?maloai=' + maloai)
          .then(res => res.text())
          .then(html => {
            brandWrapper.innerHTML = html;
          });
      });
    });
    </script>
  </form>
</div>

<?php include(__DIR__ . '/../layout/footer.php'); ?>
